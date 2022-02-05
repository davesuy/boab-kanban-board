<template>
     <div id="test">sas
      {{  dus() }}
    </div>
</template>

<script>



export default {
    name: 'Test',
    props: ['vue_script'],
    methods: {
        dus() {
            console.log(vue_script.data_var_1)
        }
    }
}
</script>

<style>


</style>