// 모든 form 제출 시 빈 필수 입력값이 있으면 막기
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