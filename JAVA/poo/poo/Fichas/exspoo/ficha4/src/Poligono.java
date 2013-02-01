
class Poligono{
	double poligonos[];
	double array_dfr[][];//o construtor passa as coordenadas para um array definido fora do contrutor. so assim pode ser usado pelos metodos
	//vai ser o array de poligonos
	double vectores[][];
	double vertice_por_vertice[];
	double normas_vectores[];
	Angulo angulos [];
	int n;
	
	public Poligono(double array[][]){//o USER só da as coordenadas na main...estas têm de ser trabalhadas na classe. para isso foram passadas para o tipo Poligono por meio de obj
		//construtor
		for (int j=0; j<n; j++){
			for (int l=0; l<n; l++){
				array[j][l]=array_dfr[j][l];//atribui as coordenadas do array que veio de fora para array_dfr da classe poligono
			}
		}
	}
	
	public void regular(){//na main faço qlqrcoisa.regular()
		for (int m=1; m<n; m++){
			vectores [m][0] = array_dfr[m-1][0]-array_dfr[m][0];//x2-x1 ...
			vectores [m][1] = array_dfr[m-1][1]-array_dfr[m][1];//y2-y1 ...
		}//ja tenho os vectores; o numero de vertices é igual ao numero de lados(vectores)que vai ser igual ao numero de angulos
		for (int a=1; a<n; a++){
			vertice_por_vertice[a] = vectores[a-1][0]*vectores[a][0] + vectores[a-1][1]*vectores[a][1];
		}//tem os vectores multiplicados
		for (int c=0; c<n; c++){
			normas_vectores[c] = Math.sqrt(Math.pow(vectores[c][0],2) + Math.pow(vectores[c][1],2));
			}
		for (int d=0; d<n; d++){
			for (int e=1; e<n; e++){
			angulos [d] = new Angulo(Math.acos(vertice_por_vertice[d] / (normas_vectores[e-1]*normas_vectores[e])));
			}
		//metodo que verifica se o poligono é regular
		//1º ve se os lados sao iguais
		for (int f=1; f<n; f++){
			if (vectores [f-1][0] == vectores[f][0] && vectores[f-1][1] == vectores[f][1] && angulos[f-1] == angulos[f]){
				System.out.print("O Poligono é regular");
			}
		}
		}
	}
}