use serde::Deserialize;
use crate::types::*;

#[derive(Deserialize)]
#[serde(tag = "cmd", rename_all = "camelCase")]
pub enum Cmd {
  ExportCommand {
    theme: String,
    path: String,
    callback: String,
    error: String,
  },
  StartCommand {
    identifier: String,
    callback: String,
    error: String,
  },
  SaveCommand {
    identifier: String,
    theme: ThemeData,
    callback: String,
    error: String,
  },
  FetchCommand {
    identifier: String,
    callback: String,
    error: String,
  },
  FetchAllCommand {
    callback: String,
    error: String,
  },
  FetchTemplatesCommand {
    // identifier: String,
    callback: String,
    error: String,
  },
  AuthenticateCommand {
    credentials: Credentials,
    callback: String,
    error: String,
  },
  IsAuthenticatedCommand {
    callback: String,
    error: String,
  }
}
