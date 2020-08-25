use crate::types::JWTCredentials;
use crate::utils::path::resolve_path;
use serde_json::from_str;
use std::fs::{write, File};
use std::io::Read;

pub fn fetch() -> JWTCredentials {
  let mut cursor = File::open(resolve_path("vendors/elementor/jwt.json")).unwrap();
  let mut data = String::new();
  cursor.read_to_string(&mut data).unwrap();
  from_str(&data).unwrap()
}

pub fn store(jwt_credentials: &JWTCredentials) {
  write(
    resolve_path("vendors/elementor/jwt.json"),
    serde_json::to_string(&jwt_credentials).unwrap().as_bytes(),
  )
  .expect("Failed writing jwt.json");
}
