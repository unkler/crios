<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const emitTest = e => console.log(e)

</script>

<template>
  <GuestLayout>
    <InputLabel value="件名">タイトル</InputLabel>
    <TextInput 
      modelValue="入力して下さい"
      @update:modelValue="emitTest"
    ></TextInput>
  </GuestLayout>
</template>