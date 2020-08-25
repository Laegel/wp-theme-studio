import * as dialog from "tauri/api/dialog";
import { get, request, ResponseType } from "tauri/api/http";
import execute from "./execute";

export const download = async (identifier) => {
  const path = await dialog.save();
  return execute("exportCommand", { path, identifier });
};

export const start = async (identifier) =>
  execute("startCommand", { identifier });

export const save = async (identifier, theme) =>
  execute("saveCommand", { identifier, theme });

export const fetch = async (identifier) =>
  execute("fetchCommand", { identifier });

export const fetchAll = async () => execute("fetchAllCommand");

export const fetchTemplates = async (token) =>
request({
  url: "http://wp-theme.studio/wp-json/wp/v2/templates",
  method: "GET",
  responseType: ResponseType.JSON
});
