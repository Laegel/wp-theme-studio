import execute from "./execute";

// export const authenticate = async (credentials) =>
//   JSON.parse(await execute("authenticateCommand", { credentials }));

export const authenticate = async (credentials) =>
  execute("authenticateCommand", { credentials });
