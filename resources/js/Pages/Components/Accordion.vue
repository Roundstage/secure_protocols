<script setup>
const {accordionName, accordionContent, accordionId} = defineProps(['accordionName', 'accordionContent', 'accordionId'])
const generateId = (string) => {
    let hash = 0;
    for (let i = 0; i < string.length; i++) {
      const char = string.charCodeAt(i);
      hash = (hash << 5) - hash + char;
      hash &= hash; // Convert to 32bit integer
    }
    return hash;
};

const generatedId = generateId(accordionName);

</script>

<template>
    <div class="accordion-item">
      <h2 class="accordion-header" :id="'heading' + generatedId">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            :data-bs-target="'#collapse' + generatedId"
            aria-expanded="false"
            :aria-controls="'collapse' + generatedId">
          {{ accordionName }}
        </button>
      </h2>
      <div
          :id="'collapse' + generatedId"
          class="accordion-collapse collapse"
          :aria-labelledby="'heading' + generatedId"
          :data-bs-parent="'#'+accordionId">
        <div class="accordion-body visible">
          {{ accordionContent }}
        </div>
      </div>
    </div>
</template>

<style scoped>

</style>
