{{-- Seja bem vindo ao Contando, {{ $user->name }} --}}
@extends('emails.partials.layout')


@section('content')



<table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row"
    role="presentation" width="640" style="width:640px;max-width:640px;" data-module="blue-preface-1">
    <!-- blue-preface-1 -->
    <tr>
        <td align="center" bgcolor="#FFFFFF" data-bgcolor="BgColor" class="container-padding">

            <table data-inner-table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation"
                class="inner-table row" width="580" style="width:580px;max-width:580px;">
                <tr>
                    <td height="40" style="font-size:40px;line-height:40px;" data-height="Spacing top">
                        &nbsp;</td>
                </tr>
                <tr>
                    <td align="center" data-bgcolor="BgColor" bgcolor="#FFFFFF">
                        <!-- content -->
                        <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation"
                            width="100%" style="width:100%;max-width:100%;">
                            <tr data-element="blue-subline" data-label="Sublines">
                                <td class="center-text" data-text-style="Sublines" align="center"
                                    style="font-family:'Barlow',Arial,Helvetica,sans-serif;font-size:14px;line-height:24px;font-weight:900;font-style:normal;color:#50C0FF;text-decoration:none;letter-spacing:1px;">
                                    <singleline>
                                        <div mc:edit data-text-edit>
                                            Bom ver você por aqui
                                        </div>
                                    </singleline>
                                </td>
                            </tr>
                            <tr data-element="blue-headline" data-label="Headlines">
                                <td class="center-text" data-text-style="Headlines" align="center"
                                    style="font-family:'Barlow',Arial,Helvetica,sans-serif;font-size:48px;line-height:54px;font-weight:900;font-style:normal;color:#222222;text-decoration:none;letter-spacing:0px;">
                                    <singleline>
                                        <div mc:edit data-text-edit>
                                            Seja bem vindo a bordo!
                                        </div>
                                    </singleline>
                                </td>
                            </tr>
                            <tr data-element="blue-headline" data-label="Headlines">
                                <td height="15" style="font-size:15px;line-height:15px;"
                                    data-height="Spacing under headline">&nbsp;</td>
                            </tr>
                            <tr data-element="blue-paragraph" data-label="Paragraphs">
                                <td class="center-text" data-text-style="Paragraphs" align="center"
                                    style="font-family:'Barlow',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:400;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                                    <singleline>
                                        <div mc:edit data-text-edit>
                                            O Contando é um sistema contruído para gerir escritórios de contabilidade. <br>
                                            Pensado por contadoes, visa otimizar as tarefas diárias da contabilidade. <br>
                                            Ative a sua conta e veja tudo que podemos fazer por você.
                                        </div>
                                    </singleline>
                                </td>
                            </tr>
                            <tr data-element="blue-header-paragraph" data-label="Paragraphs">
                                <td height="25" style="font-size:25px;line-height:25px;"
                                    data-height="Spacing under paragraph">&nbsp;</td>
                            </tr>
                            <tr data-element="blue-button" data-label="Buttons">
                                <td align="center">
                                    <!-- Button -->
                                    <table border="0" cellspacing="0" cellpadding="0" role="presentation" align="center"
                                        class="center-float">
                                        <tr>
                                            <td align="center" data-border-radius-default="0,6,36"
                                                data-border-radius-custom="Buttons" data-bgcolor="Buttons"
                                                bgcolor="#0387EC" style="border-radius: 0px;">

                                                <singleline>
                                                    <a href="#" mc:edit data-button data-text-style="Buttons"
                                                        style="font-family:'Barlow',Arial,Helvetica,sans-serif;font-size:16px;line-height:20px;font-weight:700;font-style:normal;color:#FFFFFF;text-decoration:none;letter-spacing:0px;padding: 15px 35px 15px 35px;display: inline-block;">
                                                        <span>
                                                            Ativar minha conta
                                                        </span>
                                                    </a>
                                                </singleline>

                                            </td>
                                        </tr>
                                    </table>
                                    <!-- Buttons -->
                                </td>
                            </tr>
                        </table>
                        <!-- content -->
                    </td>
                </tr>
                <tr>
                    <td height="40" style="font-size:40px;line-height:40px;" data-height="Spacing bottom">&nbsp;</td>
                </tr>
            </table>

        </td>
    </tr>
    <!-- blue-preface-1 -->
</table>






@endsection
