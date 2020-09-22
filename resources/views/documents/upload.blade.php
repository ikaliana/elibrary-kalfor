    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header justify-content-center">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="now-ui-icons ui-1_simple-remove"></i>
            </button>
            <h4 class="title title-up">Upload document</h4>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group row">
                <label for="title" class="col-sm-3 col-form-label">Title</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="name" rows="1" placeholder="Document title"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="description" rows="3" placeholder="Description"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="file" class="col-sm-3 col-form-label">File</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control-file" id="file" style="opacity: initial;margin-left: 15px; margin-top: 5px;">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3">Visibility</div>
                <div class="col-sm-9">
                  <div class="form-check" style="margin-top: 0">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" id="visibility">
                      <span class="form-check-sign"></span>
                      Private Document
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="license" class="col-sm-3 col-form-label">License</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="license" rows="1" placeholder="License"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="type" class="col-sm-3 col-form-label">Type</label>
                <div class="col-sm-9">
                  <select class="form-control" id="type"></select>
                </div>
              </div>
              <div class="form-group row map-row">
                <label for="license" class="col-sm-3 col-form-label">Datasource</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="datasource" rows="1" placeholder="Datasource"></textarea>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary btn-upload-doc">Upload</button>
          </div>
        </div>
      </div>
    </div>
