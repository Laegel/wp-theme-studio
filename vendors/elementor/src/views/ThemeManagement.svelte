<script>
  import { getContext, onMount } from "svelte";
  import { _ } from "svelte-i18n";
  import { Field, Button } from "svelma";
  import IoMdDownload from "svelte-icons/io/IoMdDownload";
  import IoIosSave from "svelte-icons/io/IoIosSave";
  import IoIosCreate from "svelte-icons/io/IoIosCreate";
  import IoIosRemove from "svelte-icons/io/IoIosRemove";

  import { chunk } from "../utils/list";
  import { fetch, fetchTemplates, save, download } from "../utils/theme";
  import templates from "../utils/templates";
  import ButtonCreate from "../components/ButtonCreate";
  import Input from "../components/Input";

  const currentTheme = getContext("currentTheme");
  const location = 'http://localhost:4444';

  import { jwt } from "../stores/jwt";

  let theme = {
    name: "",
  };
  let fetched;
  let themeTemplates;

  if (currentTheme !== "") {
    fetched = false;

    onMount(async () => {
      const response = await fetch(currentTheme);
      console.log(jwt.token);
      
      themeTemplates = await fetchTemplates(jwt.token);

      theme = response.data;
      fetched = true;
    });
  } else {
    fetched = true;
  }

  async function handleClickSave() {
    const { location } = await save(currentTheme, theme);
    console.log(location);
  }

  async function handleClickExport() {
    const { message } = await download(currentTheme);

    if (message === "ready!") {
      console.log("u did it");
    }
  }

  async function handleClickEdit(id) {
    window.location.href =
      location + `/wp-admin/post.php?post=${id}&action=elementor&redirect=${window.location.href}`;
  }
</script>

<style scoped>
  h1 {
    margin-top: 20px;
  }
  .actions {
    position: -webkit-sticky;
    position: sticky;
  }
</style>

<div class="actions">
  {#if currentTheme}
    <Button on:click={handleClickExport}>
      <span class="icon">
        <IoMdDownload />
      </span>
      {$_('export')}
    </Button>
  {/if}

  <Button on:click={handleClickSave} type="is-primary">
    <span class="icon">
      <IoIosSave />
    </span>
    {$_('save')}
  </Button>

</div>

{#if fetched}
  <h1>
    <Field label="Name">
      <Input bind:value={theme.name} />
    </Field>
  </h1>

  <div>
    <img src="https://via.placeholder.com/690x400" alt="" />
  </div>

  <ButtonCreate />
  <div class="select">
    <select>
      {#each Object.entries(templates) as [templateName, template]}
        <option>{templateName}</option>
      {/each}
    </select>
  </div>

  <div class="container">
    {#each themeTemplates as themeTemplate}
      <div class="row">

        <Button>
          <span class="icon">
            <IoIosRemove />
          </span>
          {$_('remove')}
        </Button>

        <Button on:click={() => handleClickEdit(themeTemplate.id)}>
          <span class="icon">
            <IoIosCreate />
          </span>
          {$_('edit')}
        </Button>
        {themeTemplate.slug}
      </div>
    {/each}
  </div>
{/if}
