<script>
  import { setContext, onMount } from "svelte";
  import { _ } from "svelte-i18n";
  import { Button } from "svelma";
  import SvelteRouter from "svelte-router";

  import { chunk } from "../utils/list";
  import { fetchAll, start } from "../utils/theme";
  import exportTheme from "../utils/exportTheme";
  import ButtonCreate from "../components/ButtonCreate";

  let themes = [];

  onMount(async () => {
    themes = await fetchAll();
  });

  async function handleClickExport() {
    const { message } = exportTheme("default");

    if (message === "ready!") {
      console.log("u did it");
    }
  }

  const handlePickTheme = async identifier => {
    setContext("currentTheme", identifier);
    SvelteRouter.push("/theme");
  };

  const handleClickCreate = () => {
    setContext("currentTheme", "");
    SvelteRouter.push("/theme");
  };
</script>

<h1>{$_('themes.title')}</h1>

<ButtonCreate on:click={handleClickCreate} />

{#each chunk(themes, 3) as chunked}
  <div class="columns">
    {#each chunked as { identifier, data: { name } }}
      <div class="column is-one-third">

        <img src="https://via.placeholder.com/690x400" alt="" />
        <Button on:click={() => handlePickTheme(identifier)}>{name}</Button>
        <Button on:click={handleClickExport}>Export</Button>
      </div>
    {/each}
  </div>
{/each}
