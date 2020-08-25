<script>
  import { Button } from "svelma";
  let count = 0;

  const handleClick = () => {
    count += 1;
  };
</script>

<div class="container">
  <h1 class="title">Section Example</h1>
  <h2 class="subtitle">
    A simple container to divide your page into
    <strong>sections</strong>
    , like the one you're currently reading
  </h2>
  <Button type="is-primary" on:click={handleClick}>Click!</Button>
  {count}
</div>
