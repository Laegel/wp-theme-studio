<script>
  import { createEventDispatcher } from "svelte";
  const dispatch = createEventDispatcher();

  import { Button } from "svelma";
  import { _ } from "svelte-i18n";
  import IoIosAdd from "svelte-icons/io/IoIosAdd";
</script>

<Button on:click={e => dispatch('click', e)}>
  <span class="icon">
    <IoIosAdd />
  </span>
  {$_('add')}
</Button>
