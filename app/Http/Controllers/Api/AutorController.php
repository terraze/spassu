<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListaAutorRequest;
use App\Http\Requests\Api\SalvarAutorRequest;
use App\Models\Autor;
use Illuminate\Support\Facades\DB;

class AutorController extends Controller
{
    /**
     * Retorna todos os autores
     * @param ListaAutorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ListaAutorRequest $request)
    {    
        // Obter parâmetros de ordenação ou usar valores padrão
        $sortField = $request->input('ordenarCampo', 'CodAu');
        $sortDirection = $request->input('ordenarDirecao', 'asc');

        // Obter dados ordenados
        $autores = Autor::orderBy($sortField, $sortDirection)->get();

        return response()->json($autores);
    }

    /**
     * Remove o autor especificado
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $autor = Autor::findOrFail($id);
            
            DB::beginTransaction();
            try {
                // Primeiro remove todas as associações
                $autor->removerAssociacoesLivros();
                
                // Depois remove o autor
                $autor->delete();
                
                DB::commit();

                return response()->json([
                    'message' => 'Autor excluído com sucesso'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Autor não encontrado'
            ], 404);
        } catch (\Exception $e) {            
            return response()->json([
                'message' => 'Erro ao excluir autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cria um novo autor
     * @param SalvarAutorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SalvarAutorRequest $request)
    {
        try {
            $autor = Autor::create($request->validated());
            
            return response()->json([
                'message' => 'Autor criado com sucesso',
                'data' => $autor
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualiza um autor existente
     * @param SalvarAutorRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SalvarAutorRequest $request, $id)
    {
        try {
            $autor = Autor::findOrFail($id);
            $autor->update($request->validated());
            
            return response()->json([
                'message' => 'Autor atualizado com sucesso',
                'data' => $autor
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Autor não encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
