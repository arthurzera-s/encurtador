<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Item from '@/Pages/Link/Item.vue';
import { useForm, Head } from '@inertiajs/vue3';
import axios from 'axios';

const { links, dominio} = defineProps(["links", "dominio"]);

const form = useForm({
    url: '',
    shortenedLink: null,
});

const encurtarLink = async () => {
    form.errors.url = '';
    
    try {
        const response = await axios.post(route('encurtador.store'), { url: form.url });

        if (response.status === 201) {
            const responseData = response.data;
            form.shortenedLink = responseData.url_encurtada;

            alert('Link encurtado com sucesso!');
            window.location.reload();
        } else {
            const responseData = response.data;
            form.errors.url = responseData.error || 'Erro desconhecido ao encurtar o link.';
            console.error('Erro ao encurtar o link:', responseData);
        }
    } catch (error) {
        form.errors.url = 'Erro inesperado ao encurtar o link.';
        console.error('Erro inesperado:', error);
    }
};

const deleteLink = async (id) => {
    const confirmacao = window.confirm("Tem certeza de que deseja deletar este link?");

    if (confirmacao) {
        try {
            const response = await axios.delete(route('encurtador.destroy', { id }));

            if (response.status == 200) {
                console.log('Link deletado com sucesso!');
                window.location.reload();
            } else {
                console.error('Erro ao deletar link:', response.statusText);
            }
        } catch (error) {
            console.error('Erro inesperado:', error);
        }
    }
};

</script>

<template>
    <Head title="Encurtador" />
 
    <AuthenticatedLayout>
        <div class="max-w-xl2 mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="encurtarLink">
                <input
                    v-model="form.url"
                    placeholder="Qual link deseja encurtar?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <InputError :message="form.errors.url" class="mt-2" />
                <PrimaryButton class="mt-4">Encurtar</PrimaryButton>
            </form>

            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Item
                    v-for="link in links"
                    :key="link.id"
                    :link="link"
                    :dominio="dominio"
                    @linkDeleted="deleteLink"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
