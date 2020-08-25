import tauri from "tauri/api";

export default async (cmd, args = {}) =>
  tauri.promisified({
    cmd,
    ...args,
  });
