<script>
  import { getContext, setContext, onMount } from "svelte";
  import { _ } from "svelte-i18n";
  import { Field, Button } from "svelma";
  import SvelteRouter from "svelte-router";
  import IoMdDownload from "svelte-icons/io/IoMdDownload";
  import IoIosSave from "svelte-icons/io/IoIosSave";
  import IoIosCreate from "svelte-icons/io/IoIosCreate";
  import IoIosRemove from "svelte-icons/io/IoIosRemove";

  import { jwt } from "../stores/jwt";

  import { authenticate } from "../utils/auth";

  import Input from "../components/Input";

  const credentials = {
    username: "",
    password: "",
  };

  const handleSubmitForm = async () => {
    const jwtCredentials = await authenticate(credentials);

    if (jwtCredentials.token) {
      setContext("isConnected", true);
      jwt.set(jwtCredentials);
      SvelteRouter.push("/");
    }
  };
</script>

<Field label={$_('username')}>
  <Input bind:value={credentials.username} />
</Field>

<Field label={$_('password')}>
  <Input bind:value={credentials.password} type="password" />
</Field>

<Button on:click={handleSubmitForm}>{$_('login')}</Button>
