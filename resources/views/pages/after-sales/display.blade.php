@extends('layouts.app-dashboard')
@section('content')
    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        #dashboard-container { height: 100%; display: flex; flex-direction: column; }
        .dashboard-view { display: none; height: 100%; overflow: hidden; }
        .dashboard-view.active { display: flex; flex-direction: column; height: 100%; overflow: hidden; }
    </style>

    <div id="dashboard-container">
        <div id="dashboard-1" class="dashboard-view">
            @include('pages.after-sales.dashboard-1')
        </div>
        <div id="dashboard-2" class="dashboard-view">
            @include('pages.after-sales.dashboard-2')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        const centerTextPlugin = {
            id: 'centerText',
            beforeDraw: function(chart) {
                if (chart.config.type !== 'doughnut') {
                    return;
                }

                if (chart.config.options.elements && chart.config.options.elements.center) {
                    const ctx = chart.ctx;
                    const centerConfig = chart.config.options.elements.center;
                    const fontStyle = centerConfig.fontStyle || 'Arial';
                    const txt = centerConfig.text;
                    const color = centerConfig.color || '#000';
                    const sidePadding = centerConfig.sidePadding || 20;
                    const sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 20);

                    ctx.font = "bold 12px " + fontStyle;

                    const stringWidth = ctx.measureText(txt).width;
                    const elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                    const widthRatio = elementWidth / stringWidth;
                    const newFontSize = Math.floor(30 * widthRatio);
                    const fontSizeToUse = Math.min(newFontSize, centerConfig.maxFontSize || 70);

                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    const centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                    const centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);

                    ctx.font = "bold " + fontSizeToUse + "px " + fontStyle;
                    ctx.fillStyle = color;

                    ctx.fillText(txt, centerX, centerY);
                }
            }
        };

        const centerTextHalfPlugin = {
            id: 'centerTextHalf',
            beforeDraw: function(chart) {
                const centerConfig = chart.config.options.plugins.centerTextHalf;
                if (centerConfig) {
                    const ctx = chart.ctx;
                    const {
                        width,
                        height
                    } = chart;
                    const text = centerConfig.text;

                    ctx.restore();
                    const fontSize = (height / 150).toFixed(2);
                    ctx.font = `bold ${fontSize}em sans-serif`;
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = centerConfig.color || "#000";

                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                    const textY = chart.config.options.circumference === 180 ? (height * 0.7) : (height / 2);

                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            }
        };

        // ลงทะเบียน Plugin
        Chart.register(centerTextPlugin);
        Chart.register(centerTextHalfPlugin);
        Chart.register(ChartDataLabels);

        // Switch page
        document.addEventListener('DOMContentLoaded', function() {
            const intervalTime = 5 * 60 * 1000;
            const storageKey = 'active_dashboard_id';
            
            let activeId = localStorage.getItem(storageKey) || 'dashboard-1';
            
            const activeElement = document.getElementById(activeId);
            if (activeElement) {
                activeElement.classList.add('active');
            } else {
                document.getElementById('dashboard-1').classList.add('active');
                activeId = 'dashboard-1';
            }

            setTimeout(function() {
                const nextId = (activeId === 'dashboard-1') ? 'dashboard-2' : 'dashboard-1';
                localStorage.setItem(storageKey, nextId);
                window.location.reload();
            }, intervalTime);
        });
    </script>
@endsection
