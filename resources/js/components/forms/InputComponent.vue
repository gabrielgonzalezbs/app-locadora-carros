<template>
    <div class="form-group">
        <label :for="idInput" class="form-label">{{textLabel}}</label>
        <input
            :type="typeInput"
            class="form-control"
            :id="idInput"
            :value="value"
            @input="$emit('input', $event.target.value)" >

        <div v-if="textHelp != ''" class="form-text">{{textHelp}}</div>
    </div>
</template>

<script>
export default {
    props: [
        'idInput',
        'textLabel',
        'typeInput',
        'textHelp',
        'value'
    ],

}
</script>
