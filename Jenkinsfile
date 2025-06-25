pipeline {
  agent any

  stages {
    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('React: Install dependencies') {
      steps {
        dir('frontend') {
          timeout(time: 10, unit: 'MINUTES') {
            sh 'npm install --no-audit --no-fund --prefer-offline --no-optional'
          }
        }
      }
    }

    stage('React: Build') {
      steps {
        dir('frontend') {
          // Set CI=false to reduce memory usage during build
          sh 'CI=false npm run build'
        }
      }
    }

    stage('PHP: Syntax check') {
      steps {
        dir('backend') {
          sh 'php -l index.php'
        }
      }
    }
  }

  post {
    success {
      echo '✅ CI pipeline passed for both frontend and backend'
    }
    failure {
      echo '❌ CI pipeline failed'
    }
  }
}

