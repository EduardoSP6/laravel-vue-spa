import ListProperty from "./components/properties/ListProperty";
import CreateProperty from "./components/properties/CreateProperty";
import EditProperty from "./components/properties/EditProperty";
import ListContract from "./components/contracts/ListContract";
import CreateContract from "./components/contracts/CreateContract";
import EditContract from "./components/contracts/EditContract";

export const routes = [
    {
        path: '/',
        component: ListProperty
    },
    {
       name: 'properties',
       path: '/properties',
       component: ListProperty
    },
    {
        name: 'properties.create',
        path: '/properties/create',
        component: CreateProperty
    },
    {
        name: 'properties.edit',
        path: '/properties/edit/:uuid',
        component: EditProperty
    },
    {
        name: 'contracts',
        path: '/contracts',
        component: ListContract
    },
    {
        name: 'contracts.create',
        path: '/contracts/create',
        component: CreateContract
    },
    {
        name: 'contracts.edit',
        path: '/contracts/edit/:uuid',
        component: EditContract
    }
];
