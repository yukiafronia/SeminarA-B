using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NeuralNetworkPrototype
{
    class NeuralNetworkCore : NeuralNetworkBase
    {
        /// <summary>
        /// �l�b�g���[�N�̓y����\�z����
        /// </summary>
        /// <param name="Y1">�P���p�f�[�^�̐�</param>
        /// <param name="Y2">�e�X�g�p�f�[�^�̐�</param>
        /// <param name="Y3">���͑w�̃��j�b�g��</param>
        /// <param name="Y4">�B��w�̃��j�b�g��</param>
        /// <param name="Y5">�o�͑w�̃��j�b�g��</param>
        public NeuralNetworkCore(int Y1, int Y2, int Y3, int Y4, int Y5, double Y6=0.8, double Y7=0.75) : base(Y1, Y2, Y3, Y4, Y5, alpha:Y6, eta:Y7) { }

        // �l�b�g���[�N������������
        public override void Initialize()
        {
            Random Rnd = new Random();

            // ���͑w->�B��w�̏d�݂𗐐��ŏ�����
            for (int i = 0; i < count_unit_hidden; i++)
            {
                for (int j = 0; j < count_unit_in; j++)
                {
                    weight_in_to_hidden[i,j] = Math.Sign(Rnd.NextDouble() - 0.5) * Rnd.NextDouble();
                }
                bias_hidden[i] = Math.Sign(Rnd.NextDouble() - 0.5) * Rnd.NextDouble();
            }

            // �B��w���o�͑w�̏d�݂𗐐��ŏ�����
            for (int i = 0; i < count_unit_out; i++)
            {
                for (int j = 0; j < count_unit_hidden; j++)
                {
                    weight_hidden_to_out[i, j] = Math.Sign(Rnd.NextDouble() - 0.5) * Rnd.NextDouble();
                }
                bias_out[i] = Math.Sign(Rnd.NextDouble() - 0.5) * Rnd.NextDouble();
            }
        }

        /// <summary>
        /// ���͑w->�B��w�̐M���`�d
        /// </summary>
        /// <param name="dataIndex">�P���f�[�^�̃C���f�b�N�X</param>
        public override void ForwardPropagation(int dataIndex)
        {
            double sum = 0.0;

            // ���͑w->�B��w�ւ̐M���`�d
            for (int i = 0; i < count_unit_hidden; i++)
            {
                sum = 0.0;
                for (int j = 0; j < count_unit_in; j++)
                {
                    // �d�݂Ɠ��͑wj�Ԗڂ̃��j�b�g�̏o�͒l�������đ������킹��
                    sum += weight_in_to_hidden[i, j] * output_in[dataIndex, j];
                }
                // �o�C�A�X��������sum��`�B�֐��ɗ^�������̂��B��wi�Ԗڂ̃��j�b�g�̏o��
                output_hidden[i] = sigmoid(sum + bias_hidden[i]);
            }

            // �B��w->�o�͑w�ւ̐M���`�d
            for (int i = 0; i < count_unit_out; i++)
            {
                sum = 0.0;
                for (int j = 0; j < count_unit_hidden; j++)
                {
                    sum += weight_hidden_to_out[i, j] * output_hidden[j];
                }
                output_out[i] = sigmoid(sum + bias_out[i]);
            }
        }

        /// <summary>
        /// �덷�t�`�d�@��p���ăl�b�g���[�N�𒲐�����
        /// </summary>
        /// <param name="dataIndex">�P���f�[�^�̃C���f�b�N�X</param>
        public override void BackPropagation(int dataIndex) 
        {
            double sum = 0.0;
            double[] teacher_signal_out_to_hidden = new double[count_unit_out];
            double[] learn_signal_out_to_hidden = new double[count_unit_hidden];
            
            // �o�͑w�̋��t�M�������ׂẴ��j�b�g�ɂ��ċ��߂�
            for (int i = 0; i < count_unit_out; i++)
            {
                teacher_signal_out_to_hidden[i] = (teacher_signal[dataIndex, i] - output_out[i]) * output_out[i] * (1.0 - output_out[i]);
            }

            // �o�͑w->�B��w�̏d�݂̕ω��ʂ����߂�
            for (int i = 0; i < count_unit_hidden; i++)
            {
                sum = 0.0;
                for (int j = 0; j < count_unit_out; j++)
                {
                    weight__modify_hidden_to_out[j, i] = eta * teacher_signal_out_to_hidden[j] * output_hidden[i] + alpha * weight__modify_hidden_to_out[j, i];
                    weight_hidden_to_out[j, i] += weight__modify_hidden_to_out[j, i];
                    sum += teacher_signal_out_to_hidden[j] * weight_hidden_to_out[j, i];
                }
                // �V�O���C�h�֐��̂P�������Ɗ|�����킹��
                learn_signal_out_to_hidden[i] = output_hidden[i] * (1 - output_hidden[i]) * sum;
            }

            // �o�͑w�̃o�C�A�X�̕ω��ʂ����߂�
            for (int i = 0; i < count_unit_out; i++)
            {
                bias_modify_out[i] = eta * teacher_signal_out_to_hidden[i] + alpha * bias_modify_out[i];
                bias_out[i] += bias_modify_out[i];
            }

            // �B��w->���͑w�̏d�݂̕ω��ʂ����߂�
            for (int i = 0; i < count_unit_in; i++)
            {
                for (int j = 0; j < count_unit_hidden; j++)
                {
                    weight_modify_in_to_hidden[j, i] = eta * learn_signal_out_to_hidden[j] * output_in[dataIndex, i] + alpha * weight_modify_in_to_hidden[j, i];
                    weight_in_to_hidden[j, i] += weight_modify_in_to_hidden[j, i];
                }
            }

            // �B��w�̃o�C�A�X�̕ω��ʂ����߂�
            for (int i = 0; i < count_unit_hidden; i++)
            {
                bias_modify_hidden[i] = eta * learn_signal_out_to_hidden[i] + alpha * bias_modify_hidden[i];
                bias_hidden[i] += bias_modify_hidden[i];
            }
        }

        public double sigmoid(double x)
        {
            return 1.0 / (1.0 + Math.Exp(-x));
        }

        public double tanh(double x) 
        {
            return Math.Tanh(x);
        }
    }
}