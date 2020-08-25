const ROOT: &str = "/home/laegel/Workspace/perso/wp-theme-studio/";

pub fn resolve_path(target: &str) -> String {
  format!("{}{}", ROOT, target)
}