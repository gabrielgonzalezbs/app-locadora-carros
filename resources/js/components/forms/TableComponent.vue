<template>
    <div>
        <h4>{{tableTitle}}</h4>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th v-for="header, index in headerContent" :key="index" scope="col">
                        {{header}}
                    </th>
                </tr>
            </thead>
            <tbody>
                <slot name="table-body">

                </slot>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: [
        'tableTitle',
        'headerContent',
        'bodyContent',
    ],
}
</script>
