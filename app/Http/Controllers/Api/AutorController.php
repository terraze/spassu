<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListaAutorRequest;
use App\Models\Autor;
use Illuminate\Support\Facades\DB;

class AutorController extends Controller
{
    /**
     * Retorna todos os autores
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
}
