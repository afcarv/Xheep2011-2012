package Exame5;

import java.util.ArrayList;

public class Emprestimo {
	public static void main (String[]args)
	{
		Biblioteca b = new Biblioteca();
		//Arrays:
		ArrayList <Livros> li =new ArrayList<Livros>();
		ArrayList <Leitores> leit =new ArrayList<Leitores>();
		ArrayList <Emprestimos> emp =new ArrayList<Emprestimos>();
		//Variáveis locais para determinar informações para o output:
		String Titulo = "";
		String Autor = "";
		String registo ="";
		String nLeitor = "";
		String data = "";
		//Verifica se livro existe com o Tiítulo e Autor indicados:
		for(int i=0;i<li.size();i++)
		{
			if(li.get(i).Titulo.equals(Titulo)&&li.get(i).Autor.equals(Autor))
			{
				//Se livro existe então verifica estado:
				if( li.get(i).Estado.equals("Desocupado"))
				{	
					//Se está disponível, dá indicação :
					System.out.println("O Livro encontrado e disponível.");
				}
				else
				{	
					//Senão guarda registo do livro e porucra-o em Empréstimos:
					registo=li.get(i).numRegisto;
					for(int j=0;j<emp.size();i++)
					{	
						//Se o numRegisto está presente em empréstimos guarda o numLeitor:
						if(emp.get(i).numRegisto.equals(registo))
						{
							nLeitor=emp.get(i).numLeitor;
							data=emp.get(i).dataEmprestimoFim;
							//Pesquisa no arraylist Leitores o leitor com o numLeitor de i:
							if(leit.get(i).numLeitor.equals(nLeitor))
							{
								System.out.println("Livro emprestado ao Leitor "+leit.get(i).nome+" até "+data);
							}
						}	
					}
				}
			}
		}
		System.out.println("Livro não encontrado.");
	}
}	
