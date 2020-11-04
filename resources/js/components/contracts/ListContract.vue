<template>
    <div>
        <h2>Contratos
            <router-link to="/contracts/create" class="btn btn-sm btn-success">Novo</router-link>
        </h2>
        <br/>

        <table class="table table-bordered table-striped" v-show="contracts.length > 0">
            <thead>
            <tr>
                <th>Nome do contratante</th>
                <th>E-mail do contratante</th>
                <th>Documento</th>
                <th>Imóvel</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="contract in contracts" :key="property.uuid">
                <td>{{ contract.contractor_name }}</td>
                <td>{{ contract.contractor_email }}</td>
                <td>{{ contract.document }}</td>
                <td>{{ `${contract.property.street}, ${contract.property.number}, ${contract.property.district}, ${contract.property.city}` }}</td>
                <td>
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group mr-2" role="group">
                            <router-link :to="{name: 'properties.edit', params: { uuid: contract.uuid }}" class="btn btn-sm btn-primary">
                                Editar
                            </router-link>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-show="contracts.length === 0" class="alert alert-info text-center">Vazio!</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                contracts: []
            }
        },
        created() {
            this.axios
                .get(process.env.MIX_APP_URL + '/api/contracts')
                .then(response => {
                    this.contracts = response.data;
                });
        },
        methods: {
        }
    }
</script>
