/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package exameperguntac;

import common.FicheiroDeTexto;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author Administrator
 */
public class Biblioteca {
    ArrayList<Livro> livros=new ArrayList<Livro>();
    ArrayList<Leitor> leitores=new ArrayList<Leitor>();
    ArrayList<Emprestimo> emprestimos=new ArrayList<Emprestimo>();


    void inicializaExemplo() {
        livros.add(new Livro("Livro 1"));
        livros.add(new Livro("Livro 2"));

    }

    void exportAtrasados(String fileName) {
    	//novo objecto do tipo ficheiro de texto:
        FicheiroDeTexto ficheiroDeTexto=new FicheiroDeTexto();
        
        File fileName = new File ("atrasados.txt");
        
        try {
            ficheiroDeTexto.abreEscrita(fileName);
        } catch (IOException ex) {
            Logger.getLogger(Biblioteca.class.getName()).log(Level.SEVERE, null, ex);
        }

        for(Emprestimo emprestimo: emprestimos) {
        	//Cria objecto do tipo leitor com num de leitor:
            Leitor leitor = leitores.get(emprestimo.getNumLeitor());
            //Cria objecto do tipo livro com num de livro:
            Livro livro = livros.get(emprestimo.getNumLivro());
            
            
            // Dias restantes= hoje - diferença entre (data de requisição e tempo do leitor):
            //  exemplo: dias restantes = 30/01/2009. (25/01/2009-10)
            int diasRestantesDeEmprestimo = ( Data.getDataHoje() ).diferencaData(  Data.addDiasToData (emprestimo.getDataEmprestimo(),leitor.getTempoEmprestimo()) );
            if ( diasRestantesDeEmprestimo  < 0 )
                try {
                ficheiroDeTexto.escreverLinha(leitor.getNome() + " " + leitor.getNumeroOuCategoria() + " " + -diasRestantesDeEmprestimo);
            } catch (IOException ex) {
                Logger.getLogger(Biblioteca.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

}
