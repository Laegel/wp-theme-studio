#![cfg_attr(
  all(not(debug_assertions), target_os = "windows"),
  windows_subsystem = "windows"
)]

use std::process::{Command, Stdio};

mod cmd;

mod utils;
use fs_extra::dir::{copy, CopyOptions};
use serde::Serialize;
use serde_json::value::to_value;
use std::fs::File;
use std::io::Write;
use std::collections::HashMap;
use utils::tcp::get_random_port;
use uuid::Uuid;
mod types;
use crate::utils::http::{browse, query, req};
use crate::utils::path::resolve_path;
use crate::utils::theme::{get_themes, set_themes};
use crate::utils::auth::{fetch, store};
use types::{Theme, Template, JWTCredentials, JWTPayload};

fn launch_wordpress(port: &String, theme: String) {
  println!("WP instance opening at http://localhost:{}", port);
  Command::new("wp")
    .args(vec![
      "server",
      ("--port=".to_owned() + &port).as_str(),
      "--docroot=/home/laegel/Workspace/perso/wp-theme-studio/wordpress/versions/5.4.1",
    ])
    .env("root_path", resolve_path("vendors/elementor"))
    .env("theme", theme.as_str())
    .stdout(Stdio::piped())
    .spawn()
    .expect("Failed spawning WP instance!");
}

#[derive(Serialize)]
struct Reply {
  data: String,
}

fn main() {
  tauri::AppBuilder::new()
    // .setup(move |webview, _| {
    //   let handle = webview.handle();
    //   tauri::close_splashscreen(&handle).expect("Whoopsy");
    // })
    .invoke_handler(|_webview, arg| {
      use cmd::Cmd::*;
      match serde_json::from_str(arg) {
        Err(e) => Err(e.to_string()),
        Ok(command) => {
          match command {
            ExportCommand {
              theme,
              path,
              callback,
              error,
            } => {
              println!("{},{}", theme, path);
              let body = browse(
                format!(
                  "wp-admin/admin-post.php?action=theme_export&target_theme={}",
                  theme
                )
                .as_str(),
              );
              let templates: Vec<String> = serde_json::from_str(body.unwrap().as_str()).unwrap();

              let file = File::create(path).unwrap();
              let mut writer = zip::ZipWriter::new(file);

              let options = zip::write::FileOptions::default()
                .compression_method(zip::CompressionMethod::Stored);

              writer
                .start_file("styles.css", options)
                .expect("Couldn't write stylesheet.");
              writer
                .write_all(b"/*Theme Name: Blop*/")
                .expect("Couldn't write stylesheet.");
              for template in templates.iter() {
                let body =
                  browse(format!("?export&templates={}&target_theme={}", template, theme).as_str());
                writer
                  .start_file(format!("{}.php", template).as_str(), options)
                  .expect("Couldn't write template.");
                writer
                  .write_all(body.unwrap().as_bytes())
                  .expect("Couldn't write template.");
              }

              tauri::execute_promise(
                _webview,
                move || Ok("{ message: 'ready!' }".to_string()),
                callback,
                error,
              )
            }
            StartCommand {
              identifier,
              callback,
              error,
            } => {
              let port = get_random_port().unwrap().to_string();
              launch_wordpress(&port, identifier);

              tauri::execute_promise(
                _webview,
                move || Ok(format!("{{ location: 'http://localhost:{}' }}", &port).to_string()),
                callback,
                error,
              )
            }
            SaveCommand {
              identifier,
              theme,
              callback,
              error,
            } => {
              let mut should_create = false;
              let uuid = if identifier != "" {
                identifier.clone()
              } else {
                should_create = true;
                Uuid::new_v4().to_simple().to_string()
              };

              let mut themes = get_themes();

              if should_create {
                let options = CopyOptions {
                  overwrite: true,
                  skip_exist: false,
                  buffer_size: 64000,
                  copy_inside: true,
                  depth: 0,
                };
                copy(
                  resolve_path("vendors/elementor/source"),
                  resolve_path(format!("vendors/elementor/theme-data/{}", uuid).as_str()),
                  &options,
                )
                .expect("Failed copying!");

                let item = Theme {
                  identifier: uuid.clone(),
                  data: theme,
                };
                themes.push(item);
              }

              println!("{:?}", themes);
              set_themes(themes);

              tauri::execute_promise(
                _webview,
                move || Ok(format!("{{ identifier: 'http://localhost:{}' }}", &uuid).to_string()),
                callback,
                error,
              )

              // let port = get_random_port().unwrap().to_string();
              // launch_wordpress(&port, theme);

              // tauri::execute_promise(
              //   _webview,
              //   move || Ok(format!("{{ location: 'http://localhost:{}' }}", &port).to_string()),
              //   callback,
              //   error,
              // )
            }
            FetchCommand {
              identifier,
              callback,
              error,
            } => {
              let themes = get_themes();
              let matching_theme = themes
                .into_iter()
                .find(|theme| theme.identifier == identifier)
                .unwrap();

              tauri::execute_promise(
                _webview,
                move || Ok(serde_json::to_string(&matching_theme).unwrap()),
                callback,
                error,
              )
            }
            FetchAllCommand { callback, error } => {
              let themes = get_themes();

              tauri::execute_promise(
                _webview,
                move || Ok(serde_json::to_string(&themes).unwrap()),
                callback,
                error,
              )
            }
            FetchTemplatesCommand {
              // identifier,
              callback,
              error,
            } => {
              let credentials = fetch();
              let mut headers = HashMap::new();
              headers.insert(
                "Authorization".to_string(),
                serde_json::to_value("Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93cC10aGVtZS5zdHVkaW8iLCJpYXQiOjE1OTIxNTQzODgsIm5iZiI6MTU5MjE1NDM4OCwiZXhwIjoxNTkyNzU5MTg4LCJkYXRhIjp7InVzZXIiOnsiaWQiOjF9fX0.Iw0GRyp7j3-URQMSvvCnSxoNwLMwhqSWIcnjuJ4dwm4").unwrap()
                // serde_json::to_value(format!("Bearer {}", &credentials.token)).unwrap()
              );
              println!("{:?}", headers);
              let body = req("wp-json/wp/v2/templates", "POST", serde_json::to_value("").unwrap(), headers);
              
              // let templates: Vec<Template> = serde_json::from_str(body.unwrap().as_str()).unwrap();

              // index.php/wp-json/wp/v2/templates
              // tauri::execute_promise(
              //   _webview,
              //   move || Ok(serde_json::to_string(&templates).unwrap()),
              //   callback,
              //   error,
              // )
            }
            AuthenticateCommand {
              credentials,
              callback,
              error
            } => {
              let body = query("wp-json/jwt-auth/v1/token", "POST", to_value(credentials).unwrap());
              let payload: JWTPayload = serde_json::from_str(body.unwrap().as_str()).unwrap();
              store(&payload.data);

              tauri::execute_promise(
                _webview,
                move || Ok(serde_json::to_string(&payload.data).unwrap()),
                callback,
                error,
              )
            }
            IsAuthenticatedCommand {
              callback,
              error
            } => {
              let jwt_credentials = fetch();

              // tauri::execute_promise(
              //   _webview,
              //   move || Ok(serde_json::to_string(&body.unwrap()).unwrap()),
              //   callback,
              //   error,
              // )
            }
          }
          Ok(())
        }
      }
    })
    .build()
    .run();
}
