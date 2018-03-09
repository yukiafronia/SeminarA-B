using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Drawing;
using System.ComponentModel;
using System.Xml.Serialization;
using Accord.Math;
using System.Drawing.Drawing2D;

namespace SampleApp
{
    [Serializable]
    public class Sequence : ICloneable
    {
        [XmlIgnore]
        [NonSerialized]
        private double[] input;

        [XmlIgnore]
        [NonSerialized]
        private Bitmap bitmap;

	///コードを取得
        public BindingList<String> Classes { get; set; }

        public Point[] SourcePath { get; set; }

        public int Output { get; set; }

        public int RecognizedAs { get; set; }



        public Sequence()
        {
            RecognizedAs = -1;
        }


        public string OutputName
        {
            get { return Classes[Output]; }	///name の値を返す get アクセサーを示す。
        }

        public string RecognizedAsName
        {
            get { return RecognizedAs >= 0 ? Classes[RecognizedAs] : "-"; }
        }


        public double[] Input
        {
            get
            {
                if (input == null)
                    input = Preprocess(SourcePath).Merge(2);	///テキストボックスを生成し、入力したデーターを収集
                return input;
            }
        }


        public Bitmap Bitmap
        {
            get
            {
                if (bitmap == null && SourcePath != null)
                    bitmap = ToBitmap(SourcePath);
                return bitmap;
            }
        }


        public static double[][] Preprocess(Point[] sequence)
        {
            double[][] result = new double[sequence.Length][];
            for (int i = 0; i < sequence.Length; i++)
                result[i] = new double[] { sequence[i].X, sequence[i].Y };

            double[][] zscores = Accord.Statistics.Tools.ZScores(result);

            return zscores.Add(10);
        }

	///書かれた数字の文字を最大値、最小値のx、y軸において処理
        public static Bitmap ToBitmap(Point[] sequence)
        {
            if (sequence.Length == 0)
                return null;

            int xmax = (int)sequence.Max(x => x.X);
            int xmin = (int)sequence.Min(x => x.X);

            int ymax = (int)sequence.Max(x => x.Y);
            int ymin = (int)sequence.Min(x => x.Y);

            int width = xmax - xmin;
            int height = ymax - ymin;


            Bitmap bmp = new Bitmap(width + 16, height + 16);

            Graphics g = Graphics.FromImage(bmp);


	///書いた数字の書き始めと書き終わりの値を取得し文字の判定
            for (int i = 1; i < sequence.Length; i++)
            {
                int x = (int)sequence[i].X - xmin;
                int y = (int)sequence[i].Y - ymin;
                int p = (int)Vector.Scale(0, sequence.Length, 0, 255, i);

                int prevX = (int)sequence[i - 1].X - xmin;
                int prevY = (int)sequence[i - 1].Y - ymin;

                using (Brush brush = new SolidBrush(Color.FromArgb(255 - p, 0, p)))
                using (Pen pen = new Pen(brush, 16))
                {
                    pen.StartCap = LineCap.Round;
                    pen.EndCap = LineCap.Round;
                    g.DrawLine(pen, prevX, prevY, x, y);
                }
            }

            return bmp;
        }

        public object Clone()
        {
            return MemberwiseClone();
        }
    }
}