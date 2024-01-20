<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

const { link, dominio} = defineProps(["link", "dominio"]);
const urlCompleta = dominio + "/" + link.url_new;

const copiarParaAreaDeTransferencia = () => {
  const input = document.createElement("textarea");
  input.value = urlCompleta;
  document.body.appendChild(input);
  input.select();
  document.execCommand("copy");
  document.body.removeChild(input);
  alert("Conteúdo copiado para a área de transferência!");
};

</script> 
<template>
  <div class="p-6 flex space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="20" height="20" @click="$emit('linkDeleted', link.id)" style="cursor: pointer;">
      <path fill="#ff0019" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
    </svg>
    <div class="flex-1">
      <div class="flex justify-between items-center">
        <div>
          <small class="ml-2 text-sm text-gray-600">{{
            dayjs(link.created_at).fromNow()
          }}</small>

          <small class="ml-2 text-sm text-blue-400">{{link.access_count}} acessos</small>
        </div>
      </div>
      <span>URL Encurtada: </span>
      <div class="flex space-x-1 mb-4">
        <a :href="urlCompleta" target="_blank" class="mt-4 text-lg text-blue-500">{{
          urlCompleta
        }}</a>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 448 512"
          width="20"
          height="20"
          @click="copiarParaAreaDeTransferencia"
          style="cursor: pointer"
        >
          <path
            d="M384 336H192c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16l140.1 0L400 115.9V320c0 8.8-7.2 16-16 16zM192 384H384c35.3 0 64-28.7 64-64V115.9c0-12.7-5.1-24.9-14.1-33.9L366.1 14.1c-9-9-21.2-14.1-33.9-14.1H192c-35.3 0-64 28.7-64 64V320c0 35.3 28.7 64 64 64zM64 128c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H256c35.3 0 64-28.7 64-64V416H272v32c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192c0-8.8 7.2-16 16-16H96V128H64z"
          />
        </svg>
      </div>
      <span>URL Original: </span>
      <div class="flex space-x-1">
        <a :href="link.url_original" target="_blank" class="mt-4 text-lg text-gray-500">{{
          link.url_original
        }}</a>
      </div>
    </div>
  </div>
</template>