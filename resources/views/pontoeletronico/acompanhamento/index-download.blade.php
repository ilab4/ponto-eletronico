<?php
$admin = Session::get('login.ponto.painel.admin');
$scanDir = array();
?>
  
                
                @foreach ($data as $nome => $registros)
                    
                    @php
                    $registro_dia = '';
                    $conta_registro = 0;
                    $total_registro = count($registros);
                    $horas_trabalhadas_total = 0;
                    $horas_trabalhadas_total_dia = 0;
                    $registro_nome = str_replace(" ", "", $nome);
                    @endphp
                    
                    <?php
                    
                    $nome_arquivo = $nome.'__'.md5(uniqid(time())).'.xls';
                
                    $scanDir[] = $nome_arquivo;
                    
                    
                    // Configurações header para forçar o download
                    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                    header ("Cache-Control: no-cache, must-revalidate");
                    header ("Pragma: no-cache");
                    header ("Content-type: application/x-msexcel");
                    header ("Content-Disposition: attachment; filename=\"$nome_arquivo\"" );
                    ?>

                    <table>
                            <tr>
                              <td colspan='5'><b>{{ strtoupper($nome) }}</b></td>
                            </tr>
                            <tr>
                              <td colspan='5'>{{ $data_inicio }} a {{ $data_fim }}</td>
                            </tr>
                            <tr>
                              <td colspan='5'><br></td>
                            </tr>
                            <tr>
                              <td colspan='5'><br></td>
                            </tr>
                            <tr>
                              <th>Dia</th>
                              <th>Entrada</th>
                              <th>Saida</th>
                              <th>Tempo Trabalhado</th>
                              <th>Intervalo</th>
                              <th>Obs</th>
                            </tr>
                    
                    @foreach($registros as $registro)
                        <?php

                        $varData = '';
                        if($registro_dia != $registro->data):
                            $varData = $registro->data;
                            $data_arr = explode("-", $varData);
                            $varData = $data_arr[2].'/'.$data_arr[1].'/'.$data_arr[0];
                            $ultima_hora_saida = '';
                            if(isset($horas_trabalhadas_total_dia)):
                                $horas_trabalhadas_total_dia_bkp = $horas_trabalhadas_total_dia;
                                $horas_trabalhadas_total = $horas_trabalhadas_total + $horas_trabalhadas_total_dia;
                            endif;
                            $horas_trabalhadas_total_dia = 0;
                            $varData2 = $varData;
                        endif;


                        $horas_trabalhadas = '';

                        if(!empty($registro->entrada) AND !empty($registro->saida)):
                            $entrada = new DateTime($registro->entrada);
                            $saida = new DateTime($registro->saida);
                            $intervalo = $saida->diff($entrada);

                            $intervalo_hora = $intervalo->h;
                            if(strlen($intervalo->h) == 1):
                                $intervalo_hora = '0'.$intervalo->h;
                            endif;

                            $intervalo_minuto = $intervalo->i;
                            if(strlen($intervalo->i) == 1):
                                $intervalo_minuto = '0'.$intervalo->i;
                            endif;

                            $horas_trabalhadas = $intervalo_hora.':'.$intervalo_minuto;

                            $horas_trabalhadas_total_dia = $horas_trabalhadas_total_dia + ($intervalo->h*60 + $intervalo->i);


                        endif;



                        $intervalo_pausa = '';


                        if(!empty($ultima_hora_saida) AND !empty($registro->entrada)):

                            $entrada = new DateTime($ultima_hora_saida);
                            $saida = new DateTime($registro->entrada);
                            $intervalo2 = $saida->diff($entrada);

                            $intervalo2_hora = $intervalo2->h;
                            if(strlen($intervalo2->h) == 1):
                                $intervalo2_hora = '0'.$intervalo2->h;
                            endif;

                            $intervalo2_minuto = $intervalo2->i;
                            if(strlen($intervalo2->i) == 1):
                                $intervalo2_minuto = '0'.$intervalo2->i;
                            endif;

                            $intervalo_pausa = $intervalo2_hora.':'.$intervalo2_minuto;

                        endif;

                        $ultima_hora_saida = $registro->saida;


                        ?>
                        
                        
                        
                        @if($registro_dia != $registro->data AND $registro_dia != '')
                            <?php
                            $horas_trabalhadas_total_dia_h = (int) ($horas_trabalhadas_total_dia_bkp / 60);
                            $horas_trabalhadas_total_dia_m = ($horas_trabalhadas_total_dia_bkp-($horas_trabalhadas_total_dia_h*60));

                            if(strlen($horas_trabalhadas_total_dia_h) == 1):
                                $horas_trabalhadas_total_dia_h = '0'.$horas_trabalhadas_total_dia_h;
                            endif;

                            if(strlen($horas_trabalhadas_total_dia_m) == 1):
                                $horas_trabalhadas_total_dia_m = '0'.$horas_trabalhadas_total_dia_m;
                            endif;
                            ?>
                            <tr>
                                <td colspan="3" align='left'>Total Trabalhado (Dia):</td>
                                <td><?=$horas_trabalhadas_total_dia_h?>:<?=$horas_trabalhadas_total_dia_m?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan='5'><br><br></td>
                            </tr>
                        @endif
                        <tr>
                          <td><b>{{ $varData }}</b></td>
                          <td>
                              @if($registro->entrada_status === NULL)
                                sem registro
                              @else
                                @if($registro->entrada_status === '0' OR $registro->entrada_status === '2')
                                    {{ substr($registro->entrada, 0, 5) }} 
                                @else
                                    {{ substr($registro->entrada, 0, 5) }} (*)
                                @endif
                              @endif
                          </td>
                          <td>
                              @if($registro->saida_status === NULL)
                                sem registro
                              @else
                                @if($registro->saida_status === '0' OR $registro->saida_status === '2')
                                    {{ substr($registro->saida, 0, 5) }} 
                                @else
                                    {{ substr($registro->saida, 0, 5) }} (*)
                                @endif
                              @endif
                          </td>
                          <td><?=$horas_trabalhadas?></td>
                          <td><?=$intervalo_pausa?></td>
                          <td>
                              <?php
                              $ajustes = App\PontoAjuste::where('ponto_id', '=', $registro->id)->whereIn('status', array(1, 2))->orderBy('created_at', 'ASC')->get();
                              ?>
                              @foreach($ajustes as $ajuste)
                                @if($ajuste->status == 1)
                                    Aprovado em {{ $ajuste->updated_at->format('d/m/Y') }}
                                @else
                                    Nao Aprovado em {{ $ajuste->updated_at->format('d/m/Y') }}
                                @endif
                                @if(!empty($ajuste->obs_supervisor))
                                    {{ $ajuste->obs_supervisor }}
                                @endif
                                <br>
                              @endforeach
                          </td>
                        </tr>
                        <?php
                        $registro_dia = $registro->data;
                        $conta_registro++;
                        ?>

                        @if($conta_registro == $total_registro)

                            <?php
                            $horas_trabalhadas_total = $horas_trabalhadas_total + $horas_trabalhadas_total_dia;

                            $horas_trabalhadas_total_dia_h = (int) ($horas_trabalhadas_total_dia / 60);
                            $horas_trabalhadas_total_dia_m = ($horas_trabalhadas_total_dia-($horas_trabalhadas_total_dia_h*60));

                            if(strlen($horas_trabalhadas_total_dia_h) == 1):
                                $horas_trabalhadas_total_dia_h = '0'.$horas_trabalhadas_total_dia_h;
                            endif;

                            if(strlen($horas_trabalhadas_total_dia_m) == 1):
                                $horas_trabalhadas_total_dia_m = '0'.$horas_trabalhadas_total_dia_m;
                            endif;
                            ?>
                            <tr>
                                <td colspan="3" align='left'>Total Trabalhado (Dia):</td>
                                <td><?=$horas_trabalhadas_total_dia_h?>:<?=$horas_trabalhadas_total_dia_m?></td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan='6'><br><br></td>
                            </tr>
                            <?php
                            $horas_trabalhadas_total_h = (int) ($horas_trabalhadas_total / 60);
                            $horas_trabalhadas_total_m = ($horas_trabalhadas_total-($horas_trabalhadas_total_h*60));

                            if(strlen($horas_trabalhadas_total_h) == 1):
                                $horas_trabalhadas_total_h = '0'.$horas_trabalhadas_total_h;
                            endif;

                            if(strlen($horas_trabalhadas_total_m) == 1):
                                $horas_trabalhadas_total_m = '0'.$horas_trabalhadas_total_m;
                            endif;
                            ?>
                            <tr>
                                <td colspan="3" align='left'><b>Total Trabalhado de <span style="color: #900;"><?=$data_inicio?></span> a <span style="color: #900;"><?=$data_fim?></span>:</b></td>
                                <td><b><?=$horas_trabalhadas_total_h?>:<?=$horas_trabalhadas_total_m?></b></td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan='5'><br><br></td>
                            </tr>
                        @endif

                    @endforeach 
                    
                                    </table>  
                    
                @endforeach 
                
                
                