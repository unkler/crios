<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/inertia-vue3'
import { reactive, onMounted } from 'vue'
import { getToday } from '@/common'
import Chart from '@/Components/Chart.vue'
import ResultTable from '@/Components/ResultTable.vue'

const form = reactive({
    startDate: null,
    endDate: null,
    type: 'perDay',
})

const getData = async () => {
    try {
        await axios.get('/api/analysis/', {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type,
            }
        })
        .then( res => {
            data.data = res.data.data
            data.labels = res.data.labels
            data.totals = res.data.totals
            data.type = res.data.type
        })
    } catch (e) {
        console.log(e.message)
    }
}

const data = reactive({})

onMounted(() => {
    form.startDate = getToday()
    form.endDate = getToday()
})
</script>

<template>
    <Head title="データ分析" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                データ分析
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="getData">
                            <div class="w-full">分析方法</div>
                            <div>
                                <input type="radio" id="perDay" v-model="form.type" value="perDay" checked>
                                <label for="perDay" class="mr-2">日別</label>
                                <input type="radio" id="perMonth" v-model="form.type" value="perMonth">
                                <label for="perMonth" class="mr-2">月別</label>
                                <input type="radio" id="perYear" v-model="form.type" value="perYear">
                                <label for="perYear" class="mr-2">年別</label>
                                <input type="radio" id="perYear" v-model="form.type" value="decile">
                                <label for="perYear" class="mr-2">デシル分析</label>
                                
                            </div>
                            <div>
                                From: <input type="date" name="startDate" v-model="form.startDate">
                                To: <input type="date" name="endDate" v-model="form.endDate"><br>
                            </div>
                            <div class="p-2 w-full">
                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">分析する</button>
                            </div>
                        </form>

                        <div v-if="data.data">
                            <Chart :data="data" />
                            <ResultTable :data="data" />
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
