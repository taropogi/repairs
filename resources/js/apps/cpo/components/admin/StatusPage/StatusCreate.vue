<template>
  <div class="p-2">
    <h1>Status Create</h1>
    <form>
      <div class="mb-3">
        <label for="statusName" class="form-label">Status Name</label>
        <input type="text" class="form-control" id="statusName" />
        <div id="statusNameHelp" class="form-text">
          Enter the name of the status
        </div>
      </div>
      <div class="mb-3">
        <label for="statusDescription" class="form-label"
          >Status Description</label
        >
        <textarea
          class="form-control"
          id="statusDescription"
          rows="3"
        ></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script>
export default {};
</script>

<style></style>
