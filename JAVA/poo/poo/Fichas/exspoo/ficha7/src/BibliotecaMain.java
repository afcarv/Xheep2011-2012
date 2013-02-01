import java.sql.Date;
import java.util.ArrayList;

public class BibliotecaMain{

	public static void main(String[] args) {
		
		ArrayList<Leitor> leitores = new ArrayList<Leitor>();
		
		Professor manel = new Professor("Manel", "Lisboa", 53, 914766789);
		Aluno joana= new Aluno("Joana", "Coimbra", 16, 913762363);
		Professor ricardo = new Professor("Ricardo", "Olhão", 20, 914766789);
		Aluno jose = new Aluno("José", "Portimão", 21, 281465376);
		Aluno francis = new Aluno("Francisco", "Porto", 12, 967823923);
		
		
		leitores.add(manel);
		leitores.add(joana);
		leitores.add(ricardo);
		leitores.add(jose);
		leitores.add(francis);
		
		//criar array list para livros tambem
		ArrayList <Livro> livros = new ArrayList <Livro>();
		
		Livro a = new Livro("Bananas assassinas","Pauleta",0001,"comedia");
		Livro b = new Livro("Peroloas","Julio Navarro",0002,"biologia");
		Livro c = new Livro("Biscoitos com chá","isabel alçada",0003,"cultura");
		Livro d = new Livro("Chocolate é tao bom","Salvador coelho",0004,"gastronomia");
		Livro e = new Livro("Meu pé que horror","Sebastiao Gama",0005,"comedia");
		Livro f = new Livro("Ai OPA o que é isto???","Olegario simoes",0006,"terror");
		Livro g = new Livro("é NATAL","Vanessa alexandre",0007,"cultura");
		Livro h = new Livro("Castanhas","Luis Gomes",00234,"gastronomia");
		Livro i = new Livro("Lisboa capital","José Milheiro",02034,"cultura");
		Livro j = new Livro("Arranca pra travanca","Pauleta",0020,"comedia");
		Livro k = new Livro("Epá cuidado!","Luis Gomes",0021,"comedia");
		Livro l = new Livro("Benfica","Eusebio da Silva",0022,"desporto");
		
		livros.add(a);livros.add(b);livros.add(c);livros.add(d);livros.add(e);livros.add(f);livros.add(g);livros.add(h);livros.add(i);livros.add(j);livros.add(k);livros.add(l);
		
		
		Biblioteca obj = new Biblioteca(leitores,livros);
		
		
		String deseja;
		System.out.println("O que deseja fazer?\nAdicionar leitor(0)\nAdicionar Livro(00)");
		System.out.println("Consultar livros por área ou por autor(1)");
		System.out.println("Requisitar livro, usando cota como acesso(2)");
		System.out.println("Ver se o prazo passou(3)");
		deseja = User.readString();
		
		if (deseja.equals("1")){
			System.out.println("Consultar livro por area ou por autor?(area/autor)");
			String typed = User.readString();
			if (typed.equals("area")){
				System.out.println("introduza a area a pesquisar: ");
				String qual = User.readString();
				obj.get_livros_por_area(qual);
			}
			else if (typed.equals("autor")){
				System.out.println("introduza o autor a pesquisar: ");
				String nome = User.readString();
				obj.get_livros_por_autor(nome);
			}
		}
		if (deseja.equals("2")){
			System.out.println("Seleccionou a opção requisitar livro!\nIntroduza a cota de acesso para o requisitar: ");
			double cota = User.readDouble();
			obj.checkReq(cota);
		}
	}
}