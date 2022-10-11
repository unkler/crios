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
    rfmPrms: [
        14, 28, 60, 90, 7, 5, 3, 2, 300000, 200000, 100000, 30000
    ],
})

const getData = async () => {
    try {
        await axios.get('/api/analysis/', {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type,
                rfmPrms: form.rfmPrms,
            }
        })
        .then( res => {
            data.data = res.data.data
            if(res.data.labels) data.labels = res.data.labels
            if(res.data.eachCount) data.eachCount = res.data.eachCount
            data.totals = res.data.totals
            data.type = res.data.type
            console.log(res.data)
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
                                <input type="radio" id="rfm" v-model="form.type" value="rfm">
                                <label for="rfm" class="mr-2">RFM分析</label>
                            </div>
                            <div>
                                From: <input type="date" name="startDate" v-model="form.startDate">
                                To: <input type="date" name="endDate" v-model="form.endDate"><br>
                            </div>
                            <div v-show="form.type === 'rfm'" class="my-8">
                                <table class="mx-auto">
                                    <thead>
                                        <tr>
                                            <th>ランク</th>
                                            <th>R (○日以内)</th>
                                            <th>F (○回以上)</th>
                                            <th>M (○円以上)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>5</td>
                                            <td><input type="number" v-model="form.rfmPrms[0]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[4]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[8]"></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><input type="number" v-model="form.rfmPrms[1]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[5]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[9]"></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><input type="number" v-model="form.rfmPrms[2]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[6]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[10]"></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><input type="number" v-model="form.rfmPrms[3]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[7]"></td>
                                            <td><input type="number" v-model="form.rfmPrms[11]"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-2 w-full">
                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">分析する</button>
                            </div>
                        </form>

                        <div v-if="data.data">
                            <div v-if="data.type != 'rfm'">
                                <Chart :data="data" />
                            </div>
                            <ResultTable :data="data" />
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
