<template>

    <head>
        <title v-if="userData.lang_code == 'kz'">Админ панель | Рөлді өзгерту</title>
        <title v-else-if="userData.lang_code == 'ru'">Админ панель | Изменить роль</title>
        <title v-else>Yönetici paneli | Rol adını değiştir</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" v-if="userData.lang_code == 'kz'">Рөл атын өзгерту</h1>
                    <h1 class="m-0" v-else-if="userData.lang_code == 'ru'">Изменить роль</h1>
                    <h1 class="m-0" v-else>Rol adını değiştir</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                <span v-if="userData.lang_code == 'kz'">Басты бет</span>
                                <span v-else-if="userData.lang_code == 'ru'">Главная</span>
                                <span v-else>Ana sayfa</span>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.roles.index')" v-if="userData.lang_code == 'kz'">
                                <i class="fas fa-dashboard"></i>
                                Рөлдер тізімі
                            </a>
                            <a :href="route('admin.roles.index')" v-else-if="userData.lang_code == 'ru'">
                                <i class="fas fa-dashboard"></i>
                                Список ролей
                            </a>
                            <a :href="route('admin.roles.index')" v-else>
                                <i class="fas fa-dashboard"></i>
                                Rollerin listesi
                            </a>
                        </li>
                        <li class="breadcrumb-item active" v-if="userData.lang_code == 'kz'">
                            Рөл атын өзгерту
                        </li>
                        <li class="breadcrumb-item active" v-else-if="userData.lang_code == 'ru'">
                            Изменить роль
                        </li>
                        <li class="breadcrumb-item active" v-else>
                            Rol adını değiştir
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="" v-if="userData.lang_code == 'kz'">Аты</label>
                            <label for="" v-else-if="userData.lang_code == 'ru'">Имя</label>
                            <label for="" v-else>Adı</label>
                            <input type="text" class="form-control" v-model="role.name" name="name" />
                            <validation-error :field="'name'" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            <span v-if="userData.lang_code == 'kz'">Сақтау</span>
                            <span v-else-if="userData.lang_code == 'ru'">Сохранить</span>
                            <span v-else>Kaydet</span>
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            <span v-if="userData.lang_code == 'kz'">Артқа</span>
                            <span v-else-if="userData.lang_code == 'ru'">Назад</span>
                            <span v-else>Dönüş</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
import ValidationError from "../../../Components/ValidationError.vue";

export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        ValidationError,
        Head
    },
    props: ["role"],
    created() {
        this.$store.dispatch('fetchUser');
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData.user;
        }
    },
    methods: {
        submit() {
            this.$inertia.put(
                route("admin.roles.update", this.role.id),
                this.role,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
    },
};
</script>
