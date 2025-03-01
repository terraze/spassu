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
     * @param ListaAssuntoRequest $request
     * @return \Illuminate\Http\JsonResponse
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
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

                $this->limparCache();

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
     * @param SalvarAssuntoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SalvarAssuntoRequest $request)
    {
        try {
            $assunto = Assunto::create($request->validated());

            $this->limparCache();
            
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
     * @param SalvarAssuntoRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SalvarAssuntoRequest $request, $id)
    {
        try {
            $assunto = Assunto::findOrFail($id);
            $assunto->update($request->validated());

            $this->limparCache();
            
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
