import "babel-polyfill";
import App from "./App";
import "./i18n";

import "./styles/index.scss";

const app = new App({
  target: document.body,
});

export default app;
