<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListaAssuntoRequest;
use App\Http\Requests\Api\SalvarAssuntoRequest;
use App\Models\Assunto;
use Illuminate\Support\Facades\DB;

class AssuntoController extends Controller
{
    
    /**
     * Retorna todos os assuntos
     */
    public function index(ListaAssuntoRequest $request)
    {    
        // Obter parâmetros de ordenação ou usar valores padrão
        $sortField = $request->input('ordenarCampo', 'CodAs');
        $sortDirection = $request->input('ordenarDirecao', 'asc');

        // Obter dados ordenados
        $assuntos = Assunto::orderBy($sortField, $sortDirection)->get();

        return response()->json($assuntos);
    }

    /**
     * Remove o assunto especificado
     */
    public function destroy($id)
    {
        try {
            $assunto = Assunto::findOrFail($id);
            
            DB::beginTransaction();
            try {
                // Primeiro remove todas as associações
                $assunto->removerAssociacoesLivros();
                
                // Depois remove o assunto
                $assunto->delete();
                
                DB::commit();

                return response()->json([
                    'message' => 'Assunto excluído com sucesso'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Assunto não encontrado'
            ], 404);
        } catch (\Exception $e) {            
            return response()->json([
                'message' => 'Erro ao excluir assunto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cria um novo assunto
     */
    public function store(SalvarAssuntoRequest $request)
    {
        try {
            $assunto = Assunto::create($request->validated());
            
            return response()->json([
                'message' => 'Assunto criado com sucesso',
                'data' => $assunto
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar assunto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualiza um assunto existente
     */
    public function update(SalvarAssuntoRequest $request, $id)
    {
        try {
            $assunto = Assunto::findOrFail($id);
            $assunto->update($request->validated());
            
            return response()->json([
                'message' => 'Assunto atualizado com sucesso',
                'data' => $assunto
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Assunto não encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar assunto',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
