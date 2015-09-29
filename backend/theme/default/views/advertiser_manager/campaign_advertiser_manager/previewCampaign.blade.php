<div class="modal fade bs-contact-modal" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="selectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <table class="table table-bordered text-center">
                    <tr class="active">
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('')">All</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('a%')">A</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('b%')">B</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('c%')">C</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('d%')">D</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('e%')">E</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('f%')">F</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('g%')">G</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('h%')">H</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('i%')">I</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('j%')">J</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('k%')">K</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('l%')">L</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('m%')">M</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('n%')">N</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('o%')">O</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('p%')">P</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('q%')">Q</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('r%')">R</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('s%')">S</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('t%')">T</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('u%')">U</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('v%')">V</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('w%')">W</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('x%')">X</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('y%')">Y</a></td>
                        <td><a href="javascript:;" onclick="Select.searchByKeyword('z%')">Z</a></td>
                    </tr>
                </table>
            </div>
            <div class="modal-search col-md-5">
                <input type="text" class="form-control" id="keyword" value="" name="keyword" onkeyup="Select.searchByKeyword(this.value+'%');" placeholder="Keyword">
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('text.close')}}</button>
            </div>

        </div>
    </div>
</div>
<style>
	.modal-search{min-height: 16.43px; padding: 15px;z-index:999;}
</style>