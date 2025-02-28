<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListaLivroRequest;
use App\Http\Requests\Api\SalvarLivroRequest;
use App\Models\Livro;
use Illuminate\Support\Facades\DB;

class LivroController extends Controller
{
    /**
     * Retorna todos os livros
     */
    public function index(ListaLivroRequest $request)
    {    
        // Obter parâmetros de ordenação ou usar valores padrão
        $sortField = $request->input('ordenarCampo', 'CodL');
        $sortDirection = $request->input('ordenarDirecao', 'asc');

        // Obter dados ordenados
        $livros = Livro::orderBy($sortField, $sortDirection)->get();

        return response()->json($livros);
    }

    /**
     * Cria um novo livro
     */
    public function store(SalvarLivroRequest $request)
    {
        try {
            DB::beginTransaction();

            // Cria o livro
            $livro = Livro::create($request->validated());

            // Associa os autores
            if ($request->has('Autores')) {
                $livro->autores()->attach($request->input('Autores'));
            }

            // Associa os assuntos
            if ($request->has('Assuntos')) {
                $livro->assuntos()->attach($request->input('Assuntos'));
            }

            DB::commit();
            
            return response()->json([
                'message' => 'Livro criado com sucesso',
                'data' => $livro
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Erro ao criar livro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualiza um livro existente
     */
    public function update(SalvarLivroRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $livro = Livro::findOrFail($id);
            
            // Atualiza os dados básicos
            $livro->update($request->validated());

            // Atualiza os autores
            if ($request->has('Autores')) {
                $livro->autores()->sync($request->input('Autores'));
            }

            // Atualiza os assuntos
            if ($request->has('Assuntos')) {
                $livro->assuntos()->sync($request->input('Assuntos'));
            }

            DB::commit();
            
            return response()->json([
                'message' => 'Livro atualizado com sucesso',
                'data' => $livro
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Livro não encontrado'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar livro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove o livro especificado
     */
    public function destroy($id)
    {
        try {
            $livro = Livro::findOrFail($id);
            
            DB::beginTransaction();
            try {
                // Remove todas as associações
                $livro->removerAssociacoesAutores();
                $livro->removerAssociacoesAssuntos();
                
                // Remove o livro
                $livro->delete();
                
                DB::commit();

                return response()->json([
                    'message' => 'Livro excluído com sucesso'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Livro não encontrado'
            ], 404);
        } catch (\Exception $e) {            
            return response()->json([
                'message' => 'Erro ao excluir livro',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
