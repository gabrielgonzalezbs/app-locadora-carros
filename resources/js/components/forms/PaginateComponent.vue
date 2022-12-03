<template>
    <div>
        <nav>
            <ul class="pagination justify-content-center">
                <li v-for="page, index in paginate.links" :key="index" :class="verifyActiveLink(page.active)">
                    <a class="page-link" @click.prevent="$emit('clickPage', page)">
                        <span v-html="page.label"> </span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    props: [
        'paginate',
    ],

    methods: {
        verifyActiveLink(status) {
            if (status) {
                return "page-item active";
            }

            return "page-item";
        },
    },

}
</script>

<style>
.pagination {
    cursor: pointer;
}
</style>
