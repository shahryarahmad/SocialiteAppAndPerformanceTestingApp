<script setup>
import { ref } from "vue";
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const url = ref("");
const platform = ref("mobile");
const performanceScore = ref(null);
const errorMessage = ref("");

const runLighthouseTest = async () => {
    try {
        performanceScore.value = null;
        errorMessage.value = "";

        const response = await axios.post("/api/lighthouse", {
            url: url.value,
            platform: platform.value,
        });

        performanceScore.value = response.data.performance_score;
    } catch (error) {
        errorMessage.value = "Failed to fetch performance score. Please try again.";
    }
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="container">
                            <h2>Google Lighthouse Test</h2>

                            <form @submit.prevent="runLighthouseTest">
                                <label for="url">Enter Website URL:</label>
                                <input type="url" v-model="url" required placeholder="https://example.com" />

                                <label for="platform">Select Platform:</label>
                                <select v-model="platform" required>
                                    <option value="mobile">Mobile</option>
                                    <option value="desktop">Desktop</option>
                                </select>

                                <button type="submit">Run Test</button>
                            </form>

                            <div v-if="performanceScore !== null">
                                <h3>Performance Score:</h3>
                                <p>{{ performanceScore }}</p>
                            </div>

                            <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.container {
    max-width: 500px;
    margin: auto;
    text-align: center;
}

input,
select{
    color: black;
}
input,
select,
button {
    display: block;
    width: 100%;
    margin: 10px 0;
    padding: 8px;
}

button {
    background-color: #28a745;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

.error {
    color: red;
    font-weight: bold;
}
</style>
