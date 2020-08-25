import { save } from "tauri/api/dialog";
import execute from "./execute";

export default async (themeName) => {
  const path = await save();
  return execute("exportCommand", { path, themeName });
};

export const startInstance = async (themeName) =>
  execute("startCommand", { themeName });
