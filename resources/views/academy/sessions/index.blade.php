@extends('layouts.master')
@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                </div>
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title w-100">
                                <div class="row">
                                    <div class="col-md-12 d-flex flex-row align-items-center justify-content-between">
                                        <h4 class="card-title m-0">Liste des sessions</h4>
                                        <div class="d-flex flex-row">
                                            <a href="#" class="btn btn-success" data-toggle="modal"
                                                data-target="#AddSessions"><i class="ri-add-line"></i> Ajouter</a>
                                            <a href="#" class="btn mx-1 btn-primary">PDF</a>
                                            <a href="#" class="btn btn-primary">Excel</a>
                                            <a href="#" class="btn ml-1 btn-primary">Imprimer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <!--Content start here-->
                            <div class="table-responsive">
                                <table id="Clients-table" class="table table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                                  <thead>
                                    <tr class="text-center">
                                      <th>Nom de la session</th>
                                      <th>Date de l'ouverture</th>
                                      <th>Date de la fermeture</th>
                                      <th>Nombre des etudiants</th>
                                      <th>Nombre des enseignants</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($sessions as $session)
                                      <tr class="text-center">
                                        <td>{{ $session->name }}</td>
                                        <td>{{ $session->calendar->start_date }}</td>
                                        <td>{{ $session->calendar->end_date }}</td>
                                        <td>1200</td>
                                        <td>30</td>
                                        <td>@if ($session->calendar->start_date <=(date('Y-m-d') && (date('Y-m-d')>$session->calendar->end_date)))
                                            <i class="ri-checkbox-circle-fill" style="color:green;font-size:24px"></i> Courante
                                            @elseif ((date('Y-m-d')<$session->calendar->end_date))
                                            <i class="ri-arrow-right-circle-fill" style="color:red;font-size:24px"></i> Prochaine
                                        @endif
                                        </td>
                                        <td>
                                          <div class="flex align-items-center list-user-action">
                                            {{-- <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Consulter" href="#"><i class="ri-eye-line"></i></a> --}}
                                            <span data-toggle="modal" data-target="#EditSession{{ $session->id }}">
                                                <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Modifier" href="#"><i class="ri-pencil-line"></i></a>
                                            </span>
                                            <span data-toggle="modal" data-target="#DelSession{{$session->id}}">
                                                <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Archiver" href="#" ><i class="ri-archive-line"></i></a>
                                            </span>
                                          </div>
                                        </td>
                                      </tr>
                                      <!--Edit-->
                                      <div class="modal fade" id="EditSession{{ $session->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                      aria-hidden="true">
                                      <div class="modal-dialog modal-xl" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Ajouter Session</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="container-fluid">
                                                      <!--Form start here-->
                                                      <form action="{{ route('academy-sessions.update',[$session->id]) }}" method="POST" enctype="multipart/form-data">
                                                          @csrf
                                                          @method('put')
                                                          <!--content start here-->
                                                          <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="session">Nom de la Session</label>
                                                                <select class="form-control" id="session" name="session" required>
                                                                    <option value=""></option>
                                                                    <option value="Janvier">Janvier</option>
                                                                    <option value="F??vrier">f??vrier</option>
                                                                    <option value="Mars">Mars</option>
                                                                    <option value="Avril">Avril</option>
                                                                    <option value="Mai">Mai</option>
                                                                    <option value="Juin">Juin</option>
                                                                    <option value="Juillet">Juillet</option>
                                                                    <option value="Ao??t">Ao??t</option>
                                                                    <option value="Septembre">Septembre</option>
                                                                    <option value="Octobre">Octobre</option>
                                                                    <option value="Novembre">Novembre</option>
                                                                    <option value="D??cembre">D??cembre</option>
                                                                </select>
                                                              </div>
                                                              <div class="form-group col-md-6">
                                                                <label for="session_capacity_update">Capacit?? </label>
                                                                <input type="number" class="form-control" id="session_capacity_update" name="session_capacity" required>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-md-6">
                                                                  <div class="form-group">
                                                                      <label for="exampleInputEmail1">Date de debut</label>
                                                                      <input type="date" class="form-control" name="start_date" id="start_date"
                                                                          required />
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <div class="form-group">
                                                                      <label for="exampleInputEmail1">Heure de Fin</label>
                                                                      <input type="time" class="form-control" name="end_time" id="end_time" required />
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <!--content end here-->
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn mr-2 iq-bg-danger" data-dismiss="modal">Annuler</button>
                                                  <button type="submit" class="btn iq-bg-success">Modifier</button>
                                              </div>
                                              </form>
                                              <!--Form end here-->
                                          </div>
                                      </div>
                                  </div>
                                      <!--Edit-->
                                      <!--Delete-->
                                      <div class="modal fade" id="DelSession{{$session->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Archiver Session</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              Vous ??tes sur de vouloir archiver cette Session ?
                                              <form method="POST" action="{{ route('academy-sessions.destroy',[$session->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn mr-2 iq-bg-info" data-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn iq-bg-danger">Archiver</button>
                                            </div>
                                        </form>
                                          </div>
                                        </div>
                                      </div>
                                      <!--Delete-->
                                      @endforeach
                                  </tbody>
                                </table>
                              </div>
                            <!--Content end here-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal add sessions start-->
    <div class="modal fade" id="AddSessions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Session</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <!--Form start here-->
                        <form action="{{ route('academy-sessions.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--content start here-->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="session">Nom de la Session</label>
                                    <select class="form-control" id="session" name="session" required>
                                        <option value=""></option>
                                        <option value="Janvier">Janvier</option>
                                        <option value="F??vrier">f??vrier</option>
                                        <option value="Mars">Mars</option>
                                        <option value="Avril">Avril</option>
                                        <option value="Mai">Mai</option>
                                        <option value="Juin">Juin</option>
                                        <option value="Juillet">Juillet</option>
                                        <option value="Ao??t">Ao??t</option>
                                        <option value="Septembre">Septembre</option>
                                        <option value="Octobre">Octobre</option>
                                        <option value="Novembre">Novembre</option>
                                        <option value="D??cembre">D??cembre</option>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="session_capacity">Capacit?? </label>
                                    <input type="number" class="form-control" id="session_capacity" name="session_capacity" required>
                                  </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date de l'ouverture</label>
                                        <input type="date" class="form-control" name="start_date" id="start_date"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date de fermeture</label>
                                        <input type="date" class="form-control" name="end_date" id="end_date" required />
                                    </div>
                                </div>
                            </div>
                            <!--content end here-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn mr-2 iq-bg-danger" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn iq-bg-success">Ajouter</button>
                </div>
                </form>
                <!--Form end here-->
            </div>
        </div>
    </div>
    <!--Modal add session end -->
    <script>
        $(document).ready(function() {
          $('#Clients-table').DataTable({
            "columnDefs": [{
              "targets": [0, 4]
              , "orderable": false
            }]
            , language: {
              url: 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/fr_fr.json'
            }
          });
        });
        //////////////////////////////////////////////
        $(document).ready(function() {
              //
              $('#session').keyup(function(){
            let e = $('#session');
            let l = e.val();
            if(l != ""){
                e.removeClass('is-invalid');
                e.addClass('is-valid');
            }else{
                e.removeClass('is-valid');
                e.addClass('is-invalid');
            }
        });
        $('#session_capacity').keyup(function(){
            let e = $('#session_capacity');
            let l = e.val();
            if(l.length > 1){
                e.removeClass('is-invalid');
                e.addClass('is-valid');
            }else{
                e.removeClass('is-valid');
                e.addClass('is-invalid');
            }
        });

          });
      </script>
@endsection
