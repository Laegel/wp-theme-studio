use serde_json::Value;
use std::collections::HashMap;
use tauri::api::http::{make_request, BodyType, HttpRequestOptions, ResponseType};

pub fn browse(uri: &str) -> tauri::api::Result<String> {
  let options = HttpRequestOptions {
    method: String::from("GET"),
    url: String::from("http://wp-theme.studio/".to_owned() + &uri),
    params: Some(HashMap::new()),
    headers: Some(HashMap::new()),
    body: None,
    follow_redirects: Some(false),
    max_redirections: Some(0),
    connect_timeout: Some(20000),
    read_timeout: Some(20000),
    timeout: Some(20000),
    allow_compression: Some(true),
    body_type: Some(BodyType::Auto),
    response_type: Some(ResponseType::Text),
  };
  make_request(options)
}

pub fn query(uri: &str, method: &str, body: Value) -> tauri::api::Result<String> {
  let options = HttpRequestOptions {
    body: Some(body),
    method: String::from(method),
    url: String::from("http://wp-theme.studio/".to_owned() + &uri),
    params: Some(HashMap::new()),
    headers: Some(HashMap::new()),
    follow_redirects: Some(false),
    max_redirections: Some(0),
    connect_timeout: Some(20000),
    read_timeout: Some(20000),
    timeout: Some(20000),
    allow_compression: Some(true),
    body_type: Some(BodyType::Auto),
    response_type: Some(ResponseType::Text),
  };
  make_request(options)
}

pub fn req(uri: &str, method: &str, body: Value, headers: HashMap<String, Value>) -> tauri::api::Result<String> {
  let options = HttpRequestOptions {
    body: Some(body),
    method: String::from(method),
    url: String::from("http://wp-theme.studio/".to_owned() + &uri),
    params: None,
    headers: Some(headers),
    follow_redirects: None,
    max_redirections: None,
    connect_timeout: None,
    read_timeout: None,
    timeout: None,
    allow_compression: None,
    body_type: None,
    response_type: Some(ResponseType::Text),
  };
  make_request(options)
}
