using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NeuralNetworkPrototype
{

    class TestCase
    {
        static void Main(string[] args) 
        {
            XOR();
        }

        static void XOR()
        {
            NeuralNetworkCore core = new NeuralNetworkCore(4, 4, 2, 2, 1);

            // �P���pXOR�f�[�^���́{�o�́i���t�j
            core.output_in[0, 0] = 0.0; core.output_in[0, 1] = 0.0; core.teacher_signal[0, 0] = 0.0;
            core.output_in[1, 0] = 1.0; core.output_in[1, 1] = 0.0; core.teacher_signal[1, 0] = 1.0;
            core.output_in[2, 0] = 0.0; core.output_in[2, 1] = 1.0; core.teacher_signal[2, 0] = 1.0;
            core.output_in[3, 0] = 1.0; core.output_in[3, 1] = 1.0; core.teacher_signal[3, 0] = 0.0;

            // �e�X�g�pXOR����
            core.output_in[4, 0] = 0.0; core.output_in[4, 1] = 0.0;
            core.output_in[5, 0] = 1.0; core.output_in[5, 1] = 0.0;
            core.output_in[6, 0] = 0.0; core.output_in[6, 1] = 1.0;
            core.output_in[7, 0] = 1.0; core.output_in[7, 1] = 1.0;

            // �j���[�����l�b�g���[�N��������
            core.Initialize();

            // �M���`�d�ƌ덷�t�`�d��10000��s��
            for (int i = 0; i < 10000; i++)
            {
                for (int j = 0; j < core.count_train; j++)
                {
                    core.ForwardPropagation(j);
                    core.BackPropagation(j);
                }
            }

            // �P���f�[�^��M���`�d�ɂ����ďo�͂���
            for (int j = 0; j < core.count_test; j++)
            {
                core.ForwardPropagation(core.count_train + j);
                for (int k = 0; k < core.count_unit_in; k++)
                {
                    Console.Write(core.output_in[j, k]);
                    if (k != core.count_unit_in - 1) Console.Write(", ");
                }
                Console.WriteLine();
                for (int k = 0; k < core.count_unit_out; k++)
                {
                    Console.WriteLine(core.output_out[k]);
                }
                Console.WriteLine("-----------------------------");
            }

        }
    }
}