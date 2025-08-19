<template>
    <AdminLayout>
        <!-- Breadcrumbs -->
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ userData.lang_code == 'kz'
                            ? 'Рекордтар'
                            : userData.lang_code == 'ru'
                                ? 'Записи'
                                : 'Kayıtlar'
                        }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                {{ userData.lang_code == 'kz'
                                    ? 'Басты бет'
                                    : userData.lang_code == 'ru'
                                        ? 'Главная'
                                        : 'Ana sayfa'
                                }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ userData.lang_code == 'kz'
                                ? 'Рекордтар'
                                : userData.lang_code == 'ru'
                                    ? 'Записи'
                                    : 'Kayıtlar'
                            }}
                        </li>
                    </ol>
                </div>
            </div>
        </template>

        <!-- Header buttons -->
        <template #header>
            <div class="buttons d-flex align-items-center">
                <button class="btn btn-success mr-2" @click="generateRecords" :disabled="loading">
                    <i class="fa fa-plus"></i> Сгенерировать 1000 строк
                </button>
                <button class="btn btn-danger" @click="clearRecords" :disabled="loading">
                    <i class="fa fa-trash"></i> Очистить таблицу
                </button>
                <div v-if="loading" class="spinner-border text-primary mx-3" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </template>

        <!-- Content -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label>
                            Google Sheet URL:
                            <input v-model="sheetUrl" @change="saveSheetUrl" class="form-control"/>
                        </label>
                    </div>

                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Text</th>
                                <th>Status</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="record in records" :key="record.id">
                                <td>{{ record.id }}</td>
                                <td>
                                    <input v-model="record.text"
                                           @change="updateRecord(record)"
                                           class="form-control"/>
                                </td>
                                <td>
                                    <select v-model="record.status"
                                            @change="updateRecord(record)"
                                            class="form-control">
                                        <option value="Allowed">Allowed</option>
                                        <option value="Prohibited">Prohibited</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger"
                                            @click="deleteRecord(record.id)">
                                        <i class="fa fa-trash"></i> Удалить
                                    </button>
                                </td>
                            </tr>
                            <!-- Добавление новой записи -->
                            <tr>
                                <td></td>
                                <td>
                                    <input v-model="newRecord.text" placeholder="Text" class="form-control"/>
                                </td>
                                <td>
                                    <select v-model="newRecord.status" class="form-control">
                                        <option value="Allowed">Allowed</option>
                                        <option value="Prohibited">Prohibited</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" @click="addRecord">
                                        <i class="fa fa-plus"></i> Добавить
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";

export default {
    components: { AdminLayout },
    data() {
        return {
            records: [],
            newRecord: { text: '', status: 'Allowed' },
            loading: false,
            sheetUrl: '',
        };
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData.user;
        }
    },
    mounted() {
        this.fetchRecords();
        this.loadSheetUrl();
    },
    methods: {
        async fetchRecords() {
            this.loading = true;
            const res = await fetch('/api/records');
            this.records = await res.json();
            this.loading = false;
        },
        async addRecord() {
            if (!this.newRecord.text) return;
            this.loading = true;
            await fetch('/api/records', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(this.newRecord),
            });
            this.newRecord.text = '';
            await this.fetchRecords();
        },
        async updateRecord(record) {
            this.loading = true;
            await fetch(`/api/records/${record.id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ text: record.text, status: record.status }),
            });
            this.loading = false;
        },
        async deleteRecord(id) {
            this.loading = true;
            await fetch(`/api/records/${id}`, { method: 'DELETE' });
            await this.fetchRecords();
        },
        async generateRecords() {
            this.loading = true;
            await fetch('/api/records/generate', { method: 'POST' });
            await this.fetchRecords();
        },
        async clearRecords() {
            this.loading = true;
            await fetch('/api/records/clear', { method: 'POST' });
            await this.fetchRecords();
        },
        async loadSheetUrl() {
            const res = await fetch('/api/settings/sheet-url');
            const data = await res.json();
            this.sheetUrl = data.url || '';
        },
        async saveSheetUrl() {
            await fetch('/api/settings/sheet-url', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ url: this.sheetUrl }),
            });
        },
    },
};
</script>
