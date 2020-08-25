import Home from "./views/Home.svelte";
import Themes from "./views/Themes.svelte";
import ThemeManagement from "./views/ThemeManagement.svelte";

export default {
  "/": Home,

  "/themes": Themes,

  "/themes/:theme": ThemeManagement,
};
