use crate::types::Theme;
use crate::utils::path::resolve_path;
use serde_json::from_str;
use std::fs::{write, File};
use std::io::Read;

pub fn get_themes() -> Vec<Theme> {
  let mut cursor = File::open(resolve_path("vendors/elementor/theme-data/themes.json")).unwrap();
  let mut data = String::new();
  cursor.read_to_string(&mut data).unwrap();
  from_str(&data).unwrap()
}

pub fn set_themes(themes: Vec<Theme>) {
  write(
    resolve_path("vendors/elementor/theme-data/themes.json"),
    serde_json::to_string(&themes).unwrap().as_bytes(),
  ).expect("Failed writing themes.json");
}
