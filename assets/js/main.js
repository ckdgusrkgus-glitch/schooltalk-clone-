// assets/js/main.js

// ── 1. 모든 form 제출 시 빈 필수 입력값이 있으면 막기 ──
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');

    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const requiredInputs = form.querySelectorAll('[required]');
            for (const input of requiredInputs) {
                if (!input.value.trim()) {
                    alert('필수 항목을 모두 입력해주세요.');
                    e.preventDefault();
                    return;
                }
            }
        });
    });
});

// ── 2. 출결 상태 셀 클릭 시 출석 → 지각 → 결석 순서로 순환 ──
const STATUS_CYCLE = ['출석', '지각', '결석'];

function cycleStatus(cell) {
    const current = cell.dataset.status;
    const nextIndex = (STATUS_CYCLE.indexOf(current) + 1) % STATUS_CYCLE.length;
    const next = STATUS_CYCLE[nextIndex];

    cell.dataset.status = next;
    cell.querySelector('.status-text').textContent = next;

    // 폼 제출 시 서버로 보낼 hidden input 갱신
    const date = cell.dataset.date;
    let hidden = document.querySelector(`input[name="status[${date}]"]`);
    if (!hidden) {
        hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = `status[${date}]`;
        document.getElementById('attendance-form').appendChild(hidden);
    }
    hidden.value = next;
}