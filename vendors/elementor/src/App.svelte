<script>
  import { getContext, onMount } from "svelte";
  import { Button } from "svelma";
  import SvelteRouter from "svelte-router";
  import Login from "./views/Login";
  import Home from "./views/Home";
  import Themes from "./views/Themes";
  import ThemeManagement from "./views/ThemeManagement";
  import Menu from "./components/Menu";
  import { isLoading } from "svelte-i18n";

  import { jwt } from "./stores/jwt";

  // let token;
  // jwt.subscribe(value => {
  //   token = value;
  // });

  let isConnected = getContext("isConnected") || false;
  // isConnected = true;

  // import { listen } from "tauri/api/event";

  // const promise = new Promise((resolve, reject) => {
  //   listen("port", res => resolve(res));
  // });

  function create(node) {
    const router = new SvelteRouter({
      target: node,
      mode: "hash",
      routes: [
        {
          path: "/login",
          component: Login,
        },
        {
          path: "/",
          component: Home,
        },
        {
          path: "/themes",
          component: Themes,
        },
        {
          path: "/theme",
          component: ThemeManagement,
        },
      ],
    });

    if (!isConnected) {
      SvelteRouter.replace("/login");
    }

    return {
      destroy() {
        router.destroy();
      },
    };
  }
</script>

<!-- {#await promise then value}
  <a
    href={`http://localhost:${value.payload}/wp-admin/post.php?post=27&action=elementor`}>
    Edit template
  </a>
  <a href={`http://localhost:${value.payload}/wp-admin`}>To dashboard</a>
  <Button type="is-primary" on:click={handleClickExport}>Click!</Button>
{/await} -->
{#if $isLoading}
  Please wait...
{:else}
  {#if $jwt.token}
    <Menu />
  {/if}

  <section class="section">
    <div use:create />
    <!-- <div use:create /> -->
  </section>
{/if}
