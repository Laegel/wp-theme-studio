use serde::{Deserialize, Serialize};

#[derive(Serialize, Deserialize, Debug)]
#[serde(rename_all = "camelCase")]
pub struct ThemeData {
  pub name: String,
}

#[derive(Serialize, Deserialize, Debug)]
#[serde(rename_all = "camelCase")]
pub struct Theme {
  pub identifier: String,
  pub data: ThemeData,
}

#[derive(Serialize, Deserialize, Debug)]
#[serde(rename_all = "camelCase")]
pub struct Template {
  pub id: i32,
  pub slug: String,
}

#[derive(Serialize, Deserialize, Debug)]
#[serde(rename_all = "camelCase")]
pub struct Credentials {
  pub username: String,
  pub password: String,
}

#[derive(Serialize, Deserialize, Debug)]
#[serde(rename_all = "camelCase")]
pub struct JWTCredentials {
  pub id: i32,
  pub token: String,
  pub nicename: String,
  pub first_name: String,
  pub last_name: String,
  pub display_name: String,
}

#[derive(Serialize, Deserialize, Debug)]
#[serde(rename_all = "camelCase")]
pub struct JWTPayload {
  pub success: bool,
  pub status_code: i16,
  pub code: String,
  pub message: String,
  pub data: JWTCredentials,
}
