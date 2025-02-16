<style>
    .builder-container {
        border: 2px dashed #ccc;
        min-height: 300px;
        padding: 20px;
        background: #f8f9fa;
    }
    .draggable-element {
        cursor: grab;
        padding: 10px;
        background: #007bff;
        color: white;
        border-radius: 5px;
        margin-bottom: 5px;
        z-index: 99;
    }
</style>
<div class="row">
    <div class="col-md-3">
        <h4>Elements</h4>
        <div id="elements" class="d-flex flex-column"></div>
        <!-- Elements will be loaded dynamically -->
    </div>
    <div class="col-md-9">
        <h4>Page Builder</h4>
        <div id="builder" class="builder-container"></div>
        <button id="savePage" class="btn btn-success mt-3">Save Page</button>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="editElementModal" tabindex="-1" aria-labelledby="editElementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editElementModalLabel">Edit Element</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="elementForm">
                    <input type="hidden" id="elementId">
                    <input type="hidden" id="elementDefinitionId">
                    <div id="elementFields"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                <button type="button" id="saveElementChanges" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/backoffice/page-edit.js"></script>

