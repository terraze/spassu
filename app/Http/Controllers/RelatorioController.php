<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use SqlFormatter;

class RelatorioController extends Controller
{
    /**
     * Página inicial de relatórios
     * 
     * @return View
     */
    public function index(): View
    {
        return view('relatorios');
    }

    /**
     * Relatório de livros
     * 
     * @return View
     */
    public function livros(): View
    {
        try{
            $livros = Cache::remember('relatorio.livros', 60, function () {
                return DB::table('livro_report_view')->get();
            });
            
            // Get view definition and format it
            $rawSql = DB::select("SHOW CREATE VIEW livro_report_view")[0]->{'Create View'};
            $viewDefinition = SqlFormatter::format($rawSql);
            
            return view('relatorios.livros', compact('livros', 'viewDefinition'));

        } catch (\Illuminate\Database\QueryException $e) {
            return view('error', [
                'title' => 'Erro no banco de dados',
                'message' => 'Por favor, solicite suporte técnico',
            ]);
        } catch (\Exception $e) {
            return view('error', [
                'title' => 'Erro inesperado',
                'message' => 'Ocorreu um erro inesperado ao obter o relatório de livros',
            ]);
        }
    }

    /**
     * Relatório de assuntos
     * 
     * @return View
     */
    public function assuntos(): View
    {
        try{
            $assuntos = Cache::remember('relatorio.assuntos', 60, function () {
                return DB::table('assunto_report_view')->get();
            });
            
            $rawSql = DB::select("SHOW CREATE VIEW assunto_report_view")[0]->{'Create View'};
            $viewDefinition = SqlFormatter::format($rawSql);
            
            return view('relatorios.assuntos', compact('assuntos', 'viewDefinition'));
        } catch (\Illuminate\Database\QueryException $e) {
            return view('error', [
                'title' => 'Erro no banco de dados',
                'message' => 'Por favor, solicite suporte técnico',
            ]);
        } catch (\Exception $e) {
            return view('error', [
                'title' => 'Erro inesperado',
                'message' => 'Ocorreu um erro inesperado ao obter o relatório de assuntos',
            ]);
        }
    }

    /**
     * Relatório de autores
     * 
     * @return View
     */
    public function autores(): View
    {
        try{
            $autores = Cache::remember('relatorio.autores', 60, function () {
                return DB::table('autor_report_view')->get();
            });
            
            $rawSql = DB::select("SHOW CREATE VIEW autor_report_view")[0]->{'Create View'};
            $viewDefinition = SqlFormatter::format($rawSql);
            
            return view('relatorios.autores', compact('autores', 'viewDefinition'));
        } catch (\Illuminate\Database\QueryException $e) {
            return view('error', [
                'title' => 'Erro no banco de dados',
                'message' => 'Por favor, solicite suporte técnico',
            ]);
        } catch (\Exception $e) {
            return view('error', [
                'title' => 'Erro inesperado',
                'message' => 'Ocorreu um erro inesperado ao obter o relatório de autores',
            ]);
        }
    }
} 