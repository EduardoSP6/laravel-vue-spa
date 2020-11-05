<template>
    <div>
        <h2>Imóveis
            <router-link to="/properties/create" class="btn btn-sm btn-success">Novo</router-link>
        </h2>
        <br/>

        <table class="table table-bordered table-striped" v-show="properties.length > 0">
            <thead>
            <tr>
                <th><a href="#" @click="sortProperties('owner_email')" title="Clique para ordenar">E-mail do proprietário</a></th>
                <th><a href="#" @click="sortProperties('street')" title="Clique para ordenar">Endereço</a></th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="property in sortData" :key="property.uuid">
                <td>{{ property.owner_email }}</td>
                <td>{{ `${property.street}, ${property.number}, ${property.city}, ${property.state}` }}</td>
                <td class="text-center">
                    <span class="badge badge-pill badge-success" v-show="property.status === 2">Contratado</span>
                    <span class="badge badge-pill badge-danger" v-show="property.status === 1">Não Contratado</span>
                </td>
                <td>
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group mr-2" role="group">
                            <router-link :to="{name: 'properties.edit', params: { uuid: property.uuid }}" class="btn btn-sm btn-primary">
                                Editar
                            </router-link>
                        </div>
                        <div class="btn-group mr-2" role="group">
                            <button class="btn btn-sm btn-danger" @click="deleteProperty(property.uuid, $event)">Excluir</button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-show="properties.length === 0" class="alert alert-info text-center">Vazio!</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                sortColumn: 'owner_email',
                sortOrder: 'asc',
                properties: []
            }
        },
        created() {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/properties')
                .then(response => {
                    this.properties = response.data;
                });
        },
        computed: {
            sortData() {
                return  _.orderBy(this.properties, this.sortColumn, this.sortOrder);
            }
        },
        methods: {
            sortProperties(field) {
                if (this.sortColumn === field) {
                    this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortColumn = field;
                    this.sortOrder = 'asc';
                }
            },
            deleteProperty(uuid, event) {
                event.preventDefault();
                if (confirm("Deseja realmente excluir este registro?")) {
                    this.axios
                        .delete(`${process.env.MIX_APP_URL}/api/properties/${uuid}`)
                        .then(response => {
                            let i = this.properties.map(item => item.uuid).indexOf(uuid);
                            this.properties.splice(i, 1)
                        });
                }
            }
        }
    }
</script>
