<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListaLivroRequest;
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
