<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import Pagination from "@/Components/Pagination.vue";
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'

defineProps({
  customers: Object
})

const search = ref('')

const searchCustomers = () => {
  Inertia.get(route('customers.index', { search: search.value }))
}

</script>
    
<template>
    <Head title="顧客一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                顧客一覧
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                      <section class="text-gray-600 body-font">
                        <div class="container px-5 py-8 mx-auto">
                          <FlashMessage />
                          <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                          
                            <div>

                                  <div class="relative">
                                      <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                          <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                      </div>
                                      <input type="text" name="search" v-model="search" class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                      <button
                                        @click="searchCustomers"
                                        class="text-white absolute right-2.5 bottom-2.5 bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2"
                                      >検索</button>
                                  </div>
                
                              <!-- <input type="text" name="search" v-model="search">
                              <button class="bg-blue-300 text-white py-2 px-2" @click="searchCustomers">検索</button> -->
                            </div>
                            <Link as="button" :href="route('customers.create')" class="flex ml-auto  text-white bg-indigo-500 border-0 py-3 px-6 focus:outline-none hover:bg-indigo-600 rounded font-medium">顧客登録</Link>
                          </div>
                          <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                              <thead>
                                <tr>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Id</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">氏名</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">カナ</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">電話番号</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="customer in customers.data" :key="customer.id">
                                  <td class="px-4 py-3">
                                    {{ customer.id }}
                                  </td>
                                  <td class="px-4 py-3">{{ customer.name }}</td>
                                  <td class="px-4 py-3">{{ customer.kana }}</td>
                                  <td class="px-4 py-3">{{ customer.tel }}</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                          <Pagination class="flex justify-center" :links="customers.links"></Pagination>
                      </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
    