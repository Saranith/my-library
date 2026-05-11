<script>
function updateProgressBar() {
    const completed = parseInt(document.getElementById('ch-completed').value) || 0;
    const total = parseInt(document.getElementById('ch-total').value) || 0;
    const pct = total > 0 ? Math.min(100, Math.round((completed / total) * 100)) : 0;
    document.getElementById('form-progress-bar').style.width = pct + '%';
}
function addTag() {
    const input = document.getElementById('tag-input');
    const val = input.value.trim().toUpperCase();
    if (!val) return;
    const container = document.getElementById('tags-container');
    const chip = document.createElement('span');
    chip.className = 'tag-chip px-4 py-2 bg-surface-variant border border-outline-variant text-on-surface font-inter text-[12px] flex items-center gap-2';
    chip.innerHTML = `${val} <span class="material-symbols-outlined text-sm cursor-pointer" onclick="removeTag(this)">close</span><input type="hidden" name="tags[]" value="${val}" />`;
    container.insertBefore(chip, container.lastElementChild);
    input.value = '';
}
function handleTagKey(e) { if (e.key === 'Enter') { e.preventDefault(); addTag(); } }
function removeTag(el) { el.closest('.tag-chip').remove(); }
</script>