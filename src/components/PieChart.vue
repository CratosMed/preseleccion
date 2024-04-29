<template>
    <div>
        <canvas ref="pieChartCanvas"></canvas>
    </div>
</template>
  
<script>
import { Pie } from 'vue-chartjs';

export default {
    extends: Pie,
    props: {
        chartData: {
            type: Object,
            required: true
        },
        chartOptions: {
            type: Object,
            default: () => ({ responsive: true })
        }
    },
    mounted() {
        this.renderChart(this.chartData, this.chartOptions);
    }
};
</script>
  