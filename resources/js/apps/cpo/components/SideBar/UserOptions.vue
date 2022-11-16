<template>
    <div class="dropdown my-2">
        <a
            href="#"
            class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
            id="dropdownUser1"
            data-bs-toggle="dropdown"
            aria-expanded="false"
        >
            <img
                src="https://github.com/mdo.png"
                alt=""
                width="32"
                height="32"
                class="rounded-circle me-2"
            />
            <strong>Richard Bernisca</strong>
        </a>
        <ul
            class="dropdown-menu dropdown-menu-dark text-small shadow"
            aria-labelledby="dropdownUser1"
        >
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li>
                <a
                    class="dropdown-item"
                    href="#"
                    @click.prevent="$emit('log-out')"
                    >Sign out</a
                >
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    emits: ["log-out"],
};
</script>

<style></style>
